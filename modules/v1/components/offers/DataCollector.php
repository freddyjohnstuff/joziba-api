<?php

namespace app\api\modules\v1\components\offers;

use yii\db\Query;
use app\models\Offers;

/**
 * Класс сбора данных
 */
class DataCollector
{
    /**
     * Данные key => value
     *
     * @var array
     */
    private $data = [];
    /**
     * текущий request
     *
     * @var mixed
     */
    private $requestData;

    public function __construct($fields)
    {
        $this->fields = $fields;
        $request = \Yii::$app->getRequest();
        if ($request->isPost) {
            $this->requestData = $request->post();
        } elseif ($request->isGet) {
            $this->requestData = $request->get();
        }
    }
    /**
     * Сбор данных из запроса
     * С учетом защищенных полей
     * Если по ключу данных нет будет поиск с учетом алиасов
     *
     * @return array
     */
    public function collect(): array
    {
        foreach ($this->fields as $key => $default) {
            if (in_array($key, $this->fields->protectedFields())) {
                $this->data[$key] = $default;
            } else {
                $this->data[$key] =  $this->getDataFromRequest($this->requestData, $key, $default);
            }
        }
        return $this->data;
    }

    /**
     * Получить и обработать данные
     *
     * @param $data $data
     * @param $key $key
     * @param $default $default
     *
     * @return void
     */
    public function getDataFromRequest($data, $key, $default)
    {
        $callable = $this->fields->processors($key);
        if (isset($data[$key])) {
            $value = $data[$key];
        } else {
            $value = $this->findAlias($data, $key) ? $this->findAlias($data, $key) : $default;
        }
        return $callable($value);
    }

    /**
     * Поиск значения по алиасам поля
     *
     * @param  $data $data
     * @param  $key  $key
     *
     * @return mixed
     */
    private function findAlias($data, $key)
    {
        $aliases = $this->fields->aliases();
        if (isset($aliases[$key])) {
            foreach ($aliases[$key] as $aliasKey) {
                if (isset($data[$aliasKey])) {
                    return $data[$aliasKey];
                }
            }
        }
        return false;
    }

    /**
     * Данные текущего запроса
     *
     * @return array
     */
    public static function requestData()
    {
        $data = \yii\helpers\ArrayHelper::merge(
            \Yii::$app->getRequest()->post(),
            \Yii::$app->getRequest()->get(),
        );
        return $data;
    }

    /**
     * Так как ожидается работа с прокси, IP берем тот который передала прокся.
     * если ничего не передано IP самой Прокси
     * @return void
     */
    public static function getUserIpFromProxy()
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? \Yii::$app->request->UserIP;
    }

    /**
     * Выдает идентификатор текущей CPA сессии
     *
     * @return string
     */
    public static function getCurrentSessionId(): string
    {
        $cpa_session = $_COOKIE['cpa_session'] ?? \Yii::$app->getSecurity()->generateRandomString(128);

        \Yii::$app->response->cookies
            ->add(
                new \yii\web\Cookie([
                    'name' => 'cpa_session',
                    'value' => $cpa_session,
                ])
            );
        return $cpa_session;
    }

    /**
     * Метод ищет id первого посещения в сессии
     *
     * @return int|null
     */
    public static function getOfferVisitEventIdBySession(): ?int
    {
        return (new Query())
            ->select('id')
            ->from('{{%events}}')
            ->where(['session' => static::getCurrentSessionId()])
            ->andWhere(['type' => \app\models\Events::EVENT_TYPE_OFFER_VISIT])
            ->orderBy(['ts' => SORT_ASC])
            ->limit(1)
            ->createCommand()
            ->queryScalar();
    }

    /**
     * Получает офер по урлу
     *
     * @param String $url
     *
     * @return Offer|null
     */
    public static function getOfferByUrl(string $url)
    {
        if (preg_match('/https?:\/\/.+/', $url)) {
            $domain = parse_url($url, PHP_URL_HOST);
        } else {
            $domain = $url;
        }
        if ($domain) {
            return Offers::find()
                ->JoinWith('offersDomains d')
                ->where(['d.domain' => $domain])
                ->one();
        }
        return null;
    }
}
