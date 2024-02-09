<?php

namespace app\api\modules\v1\components\partners;

use Yii;
use yii\base\Component;
use app\integrations\partner\base\Partner;

/**
 * Класс позволяет выбрать партнера для отправки данных
 */
class PartnerManager
{
    /**
     * Массив Ассоциаций партнеров согласно схеме [partner_key => класс обработчик]
     *
     * @var array
     */
    public $partnersAssociation = [];

    /**
     * массив партнеров, которые отказали в регистрации, или которым отправлять данные в рамках текущей сессии не нужно.
     *
     * @var array
     */
    private $failedPartners = [];

    /**
     * int
     *
     * @var mixed
     */
    public $dayOfWeek;

    /**
     * data
     *
     * @var array
     */
    private $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->dayOfWeek = date('w', time());
    }

    /**
     * Получить подходящего партнера по исходным данным
     *
     * @param array $data
     *
     * @return Partner
     */
    public function getPartner(array $data): Partner
    {
        $this->data = $data;
        $partner =  $this->getPartnerByData($data);
        if ($partner) {
            return $partner;
        }
        return $this->getPartnerWithPriority();
    }

    /**
     * Получить подходящего партнера по входящим данным
     *
     * @param array $data
     *
     * @return Partner|null
     */
    private function getPartnerByData(array $data): ?Partner
    {
        if (isset($data['partner_id'])) {
            if (in_array($data['partner_id'], $this->failedPartners)) {
                \Yii::warning('partner_id зафэйлен будет выбран по приоритетам', 'partners');
                return null;
            }
            return $this->getPartnerById($data['partner_id']);
        } else {
            Yii::info('не указан partner_id в data');
        }
        return null;
    }

    /**
     * Получить партнера по id
     *
     * @param int $id
     *
     * @return Partner|null
     *
     */
    private function getPartnerById(int $id): ?Partner
    {
        $partnerModel = \app\models\Partners::findOne($id);
        if ($partnerModel) {
            Yii::info('Партнер найден по id=' . $id, 'partners');
            return $this->getPartnerWithKey($id, $partnerModel->partner_key);
        } else {
            Yii::info('Партнер не найден по id=' . $id, 'partners');
        }
        return null;
    }

    /**
     * Получает партнера по ключу или false
     *
     * @param $key
     *
     * @return Partner|null
     */
    private function getPartnerWithKey(int $id, string $key): ?Partner
    {

        if (isset($this->partnersAssociation[$key])) {
            $partner = $this->getPartnerClassInstance($this->partnersAssociation[$key], $id);
            return $partner;
        }

        Yii::error('Нет ассоциации для ключа партнера ' . $key, 'partners');
        return null;
    }

    /**
     * Method Инстанциирует класс партнера или null
     *
     * @param string $class
     *
     * @return Partner|null
     */
    private function getPartnerClassInstance(string $class, $id): ?Partner
    {
        try {
            $PartnerInstance = \Yii::createObject(
                [
                    'class' => $class,
                ],
                [$id]
            );
            if ($PartnerInstance) {
                return $PartnerInstance;
            }
        } catch (\Exception $e) {
            Yii::error('Не удалось инстанцировать класс партнера' . $e->getMessage(), 'partners');
        }
        return null;
    }

    /**
     * Возвращает партнера согласно таблице приоритетов
     *
     * @return Partner|null
     */
    public function getPartnerWithPriority(): ?Partner
    {
        $country = $this->data['country'];

        $query = (new \yii\db\Query())
            ->select('partner_id')
            ->from('{{%partners_scores}}')
            ->where(['country' => $country])
            ->andWhere(['week_day' => $this->dayOfWeek])
            ->orderBy(['score' => SORT_DESC]);
        $command = $query->createCommand();
        $ids = $command->queryColumn();
        $ids = array_diff($ids, $this->failedPartners);
        foreach ($ids as $id) {
            $partner = $this->getPartnerById($id);
            if ($partner) {
                Yii::info('Партнер выбран по приоритетам id=' . $partner->partnerData->id, 'partners');
                return $partner;
            }
        }
        Yii::error('Партнер не выбран по приоритетам ' . json_encode(['query' => $command->rawSql, 'failedPartners' => $this->failedPartners]), 'partners');
        return null;
    }

    /**
     * Добавить id партнера в зафэйленные
     *
     * @param string $key
     * @return void
     */
    public function addToFailedPartners(int $id)
    {
        array_push($this->failedPartners, $id);
        return $this->failedPartners;
    }
}
