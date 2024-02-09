<?php
namespace app\api\modules\v1\components\tracker\binom\v1;

use app\api\modules\v1\components\tracker\Tracker;
use Curl\Curl;

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
        $this->addParamsToUrl($params);
        $curl = new Curl();
        $curl->get($this->url);
        if ($curl->getHttpStatusCode() === 200) {
            return $curl->response;
        }
        return false;
    }
    
    protected function addParamsToUrl($params)
    {
        $this->url = $this->url.'?api_key='.$this->apiKey . '&' . http_build_query($params);
    }
}
