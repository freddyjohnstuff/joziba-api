<?php


namespace app\api\modules\v1\components\conversion\facebook;

use app\api\modules\v1\components\conversion\Logger;
use app\api\modules\v1\components\conversion\PrepareData;
use app\models\ConversionLog;
use app\models\ConversionQueue;
use app\models\ConversionStatus;
use app\models\CpaDeposits;
use app\models\CpaRegistrations;
use app\models\Events;
use app\models\Pixels;
use DateTime;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class FacebookPrepareData implements PrepareData
{
    protected ConversionQueue $model;
    public static string $formatDate = 'Y-m-d H:i:s';
    /**
     * FacebookPrepareData constructor.
     * @param ConversionQueue $model
     */
    public function __construct(ConversionQueue $model)
    {
        $this->model = $model;
    }

    /**
     * @param Logger $logger
     * @return array|false
     * @throws Exception
     */
    public function prepare(Logger $logger)
    {
        $postbackList = $this->getPostbackList($this->model);
        /* @var ActiveRecord $one */
        $pixels = Pixels::find()
                ->where(['status' => Pixels::ACTIVE_STATUS])
                ->andWhere(['IN', 'id', $this->model->pixels])
                ->all();
        $data = [];
        if ($postbackList) {
            foreach ($postbackList as $one) {
                $data = ArrayHelper::merge($this->getData($one, $pixels), $data);
            }
        }
        return $data;
    }

    /**
     * @param ConversionQueue $model
     * @return array|ActiveRecord[]
     * @throws Exception
     */
    protected function getPostbackList(ConversionQueue $model)
    {
        if ($model->method == FacebookApi::EVENT_PURCHASE) {
            $postbackList = CpaDeposits::find()->joinWith(['postbackEvent', 'registrationInfo']);
            $alias = CpaDeposits::ALIAS_POSTBACK_EVENT;
        } else {
            $postbackList = CpaRegistrations::find()->joinWith(['postbackEvent']);
            $alias = CpaRegistrations::ALIAS_POSTBACK_EVENT;
        }
        /** @var  ActiveRecord $modelPostback */
        return $postbackList
            ->where(['>=', $alias.'.ts', $this->prepareDate($model->date_start)])
            ->andWhere(['<=', $alias.'.ts',  $this->prepareDate($model->date_end, true)])
            ->all();
    }

    /**
     * @param $one
     * @param $pixels
     * @return array
     */
    protected function getData($one, $pixels)
    {
        $data = [];
        $userData = $this->getUserData($one);
        $eventSourceUrl =  $this->model->url ?? null;
        if ($this->checkByOffers($one) === false) {
            return $data;
        }
        foreach ($pixels as $pixel) {
            /* @var Pixels $pixel */
            if ($this->model->send_double != 1 && $this->isSuccessPostback($one, $pixel)) {
                continue;
            }
            $data[] = $this->getDataForOneRequest([
                'userData' => $userData,
                'eventSourceUrl' => $eventSourceUrl,
                'pixel' => $pixel,
                'event' => $one,
            ]);
        }

        return $data;
    }

    protected function getDataForOneRequest($data)
    {
        return [
            'body' => [
                'data' => [
                    'user_data' => $data['userData'],
                    'custom_data' => [
                        'currency' => 'USD',
                        "value" => $data['event']->payout_usd ?? 0,
                    ],
                    'event_name' => $this->model->method,
                    'event_time' => time(),
                    'event_source_url' => $data['eventSourceUrl'],
                    'action_source' => 'website'
                ],
            ],
            'url' => \Yii::$app->params['facebook_conversion_url'].
                '/'.$data['pixel']->pixel_id.
                '/events?access_token='.
                $data['pixel']->access_token,
            'postBackId' => $data['event']->postbackEvent->id,
            'method' => $this->model->method,
            'pixelId' => $data['pixel']->id
        ];
    }

    /**
     * @param $one
     * @return array|bool|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    protected function checkByOffers($one)
    {
        if (empty($this->model->offers)) {
            return true;
        }
        $condition = '';
        foreach ($this->model->offers as $key => $url) {
            if ($key > 0) {
                $condition .= ' or ';
            }
            $condition .= Events::tableName().".preland_url like '$url'";
        }
        $eventId = $one->registrationInfo->offer_visit_event_id ?? $one->offer_visit_event_id;
        if ($eventId === null) {
            return false;
        }
        $sql = "select * from ".Events::tableName()." where id=$eventId and ($condition)";
        return \Yii::$app->db->createCommand($sql)->queryOne();
    }

    /**
     * @param $date
     * @param false $end
     * @return string
     * @throws \Exception
     */
    protected function prepareDate($date, $end = false)
    {
        $date = new DateTime($date);
        if ($end) {
            $date->setTime(23, 59, 59);
        } else {
            $date->setTime(0, 0, 0);
        }
        return $date->format(self::$formatDate);
    }

    /**
     * @param $one
     * @return array
     */
    public function getUserData($one)
    {
        $fbp = $one->postbackEvents->cookiehash ?? null;
        $fbpData = [];
        if ($fbp && strripos($fbp, 'fb.') !== false) {
            $fbpData = ['fbp' => $fbp];
        }
        $userData = $one->registrationInfo ?? $one;
        return ArrayHelper::merge($fbpData, [
            'em' => $userData->email,
            'ph' => $userData->phonecc . $userData->phone,
            'ln' => $userData->lastname,
            'fn' => $userData->firstname,
            'ct' => $userData->postbackEvent->country ?? '',
            'country' => $userData->postbackEvent->country ?? '',
        ]);
    }


    /**
     * @param $postback
     * @param $pixel
     * @return bool
     */
    protected function isSuccessPostback($postback, $pixel) : bool
    {
        $successPostback = ConversionLog::find()->where([
            'event_id' => $postback->id,
            'pixel_id' => $pixel->id,
        ])->one();
        if ($successPostback !== null && $successPostback->status_id == ConversionStatus::SUCCESS) {
            return true;
        }
        return false;
    }
}
