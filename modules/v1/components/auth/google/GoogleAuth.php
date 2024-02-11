<?php
namespace app\modules\v1\components\auth\google;

use Curl\Curl;

class GoogleAuth
{
    const BASE_URL = 'https://accounts.google.com/o/oauth2/';
    const BASE_URL_USER_INFO = 'https://www.googleapis.com/oauth2/v3/';

    public static function getLink($redirectUrl)
    {
        $params = [
            'client_id'     => \Yii::$app->params['google_client_id'],
            'redirect_uri'  => $redirectUrl,
            'response_type' => 'code',
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email ' .
                               'https://www.googleapis.com/auth/userinfo.profile',
        ];

        return self::BASE_URL . 'auth?' . urldecode(http_build_query($params));
    }
    
    public static function getUserInfo($code, $redirectUrl)
    {
        $params = [
            'client_id'     => \Yii::$app->params['google_client_id'],
            'client_secret' => \Yii::$app->params['google_client_secret'],
            'redirect_uri'  => $redirectUrl,
            'grant_type'    => 'authorization_code',
            'code'          => $code
        ];
        $curl = new Curl();
        $curl->post(self::BASE_URL . 'token', $params);
        if ($curl->getHttpStatusCode() == 200) {
            $response = $curl->getResponse();
            $params = [
                'access_token' => $response->access_token ?? null,
                'id_token'     => $response->id_token ?? null,
                'token_type'   => $response->token_type ?? null,
            ];
            $curl->get(self::BASE_URL_USER_INFO . 'userinfo', $params);
            if ($curl->getHttpStatusCode() == 200) {
                return $curl->getResponse();
            }
        }
        return false;
    }
}
