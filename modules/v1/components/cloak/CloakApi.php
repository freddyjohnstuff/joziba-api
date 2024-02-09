<?php
namespace app\api\modules\v1\components\cloak;

use Curl\Curl;

class CloakApi
{
    public static function getCompany($params)
    {
        if (isset($params['id'])) {
            $curl = new Curl();
            $curl->setHeaders([
                'Authorization' => self::getToken(),
                'Content-Type' => 'application/json'
            ]);
            $curl->setOpts(
                [
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FRESH_CONNECT => true,
                    CURLINFO_HEADER_OUT => true
                ]
            );
            $curl->get(\Yii::$app->params['cloak_service_api'].'/company/' . $params['id']);
            if ($curl->getHttpStatusCode() === 200) {
                return $curl->response;
            }
        }
    }

    protected static function getToken()
    {
        return \Yii::$app->request->getHeaders()->get('Authorization');
    }
}
