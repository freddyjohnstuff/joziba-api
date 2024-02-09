<?php
namespace app\api\modules\v1\components\conversion\facebook;

use app\api\modules\v1\components\conversion\ConversionApi;
use app\api\modules\v1\components\conversion\Logger;
use app\models\ConversionStatus;
use Curl\MultiCurl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class FacebookApi implements ConversionApi
{
    const EVENT_PURCHASE =  'Purchase';
    const EVENT_LEAD =  'Lead';
    const EVENT_COMPLETE_REGISTRATIONS =  'CompleteRegistration';
    
    public array $dataRequest = [];
    public array $options = [
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_FOLLOWLOCATION => 0,
    ];
    public array $hashList = ['em', 'ph', 'ln', 'fn', 'ct', 'country'];

    /**
     * FacebookApi constructor.
     * @param $data
     * @param array $options
     */
    public function __construct($data, $options = [])
    {
        $this->dataRequest = $data;
        $this->setOptions($options);
    }

    /**
     * @param Logger $logger
     * @throws \ErrorException
     */
    public function send(Logger $logger)
    {
        $multiCurl = new MultiCurl();
        $multiCurl->complete(function ($instance) use ($logger) {
            $response = Json::encode($instance->response);
            $logger->addLog([
                'request' => Json::encode($this->dataRequest[$instance->id]['body']['data']),
                'postback_id' => $this->dataRequest[$instance->id]['postBackId'],
                'type' => $this->dataRequest[$instance->id]['method'],
                'pixel_id' => $this->dataRequest[$instance->id]['pixelId'],
                'response' => $response,
                'status_id' => $this->getStatus($response),
            ]);
        });
        $multiCurl->setOpts($this->options);
        foreach ($this->dataRequest as $single) {
            $this->validate($single);
            $single['body']['data']['user_data'] = $this->toHash($single['body']['data']['user_data']);
            $single['body']['data'] = [Json::encode($single['body']['data'])];
            $multiCurl->addPost($single['url'], $single['body']);
        }

        $multiCurl->start();
    }

    /**
     * @param $options
     */
    public function setOptions($options)
    {
        if (!empty($options)) {
            $this->options = $options;
        } else {
            $proxy_gate = \Yii::$app->params['proxy_gate'] ?? null;
            $proxy_user = \Yii::$app->params['proxy_user'] ?? null;
            $proxy_pass = \Yii::$app->params['proxy_pass'] ?? null;
            if (!empty($proxy_gate) && !empty($proxy_user) && !empty($proxy_pass)) {
                $proxy_auth = $proxy_user . ':' . $proxy_pass;
                $this->options = ArrayHelper::merge($this->options, [
                    CURLOPT_PROXY => $proxy_gate,
                    CURLOPT_PROXYUSERPWD => $proxy_auth,
                ]);
            }
        }
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    protected function validate($data)
    {
        $validateArray = [
            'request' => $data['body']['data'] ?? null,
            'postBackId' => $data['body']['data'] ?? null,
            'method' => $data['body']['data'] ?? null,
            'pixelId' => $data['body']['data'] ?? null,
        ];
        foreach ($validateArray as $key => $val) {
            if (empty($val)) {
                throw new \Exception('Validate error for key ' . $key);
            }
        }
        return true;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function toHash($data)
    {
        foreach ($data as $k => &$v) {
            if (in_array($k, $this->hashList)) {
                $v = hash('sha256', mb_strtolower($v));
            }
        }
        return $data;
    }
    
    /**
     * @param $response
     * @return int
     */
    protected function getStatus($response)
    {
        $response = Json::decode($response);
        $response = end($response);
        $result = $response['events_received'] ?? false;
        if ($result != '1') {
            return ConversionStatus::ERROR;
        }
        return ConversionStatus::SUCCESS;
    }
}
