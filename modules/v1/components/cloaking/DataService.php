<?php


namespace app\api\modules\v1\components\cloaking;


use Curl\Curl;

class DataService
{
    protected const BASE_URL = 'https://dataservice.groscloud.com';
    public static function getCountry($ip)
    {
        $curl = new Curl();
        $curl->setOpts(
            [
                CURLOPT_SSL_VERIFYPEER => false
            ]
        );
        $curl->get(self::BASE_URL . '/ip', ['ip' => $ip]);

        return $curl->response->geo->country_code ?? null;
    }
}