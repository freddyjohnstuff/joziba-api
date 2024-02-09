<?php

namespace app\api\modules\v1\components\tracker\binom\v2;

use app\api\modules\v1\components\tracker\Tracker;
use Curl\Curl;
use yii\helpers\Json;

class Binom implements Tracker
{
    public string $url;
    public string $apiKey;
    public function __construct()
    {
        $this->url = \Yii::$app->params['tracker_api_url'];
        $this->apiKey = \Yii::$app->params['tracker_api_key'];
    }

    public function getCompany(array $params)
    {
        $params = \yii\helpers\ArrayHelper::merge($params, ['action' => 'campaign@get', 'api_key' => $this->apiKey]);
        $this->addParamsToUrl($params);
        $curl = new Curl();
        $curl->get($this->url);
        if ($curl->getHttpStatusCode() === 200) {
            $responseAr = Json::decode($curl->getRawResponse());
            $status = $responseAr['status'] ?? false;
            if ($status == 1) {
                return $responseAr;
            }
        }

        return false;
    }

    protected function addParamsToUrl($params)
    {
        $this->url = $this->url . '?' . http_build_query($params);
    }
}
