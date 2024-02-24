<?php

namespace app\lib\tools\clients;

use app\models\Clients;
use app\models\ClientTokenHolder;

final class ClientTools
{

    private static ?ClientTools $instance = null;

    /**
     * @return ClientTools
     */
    public static function getInstance(): ClientTools
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     * multiple construct, clone, wakeup,
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}


    /**
     * @param $token
     * @return Clients|null
     */
    public function getClientByAccessToken($token) {

        if(!$token) {
            return null;
        }

        /** @var ClientTokenHolder $tokenHolder */
        $tokenHolder = ClientTokenHolder::find()
            ->where(['access_token' => $token])
            ->one();
        if(!$tokenHolder) {
            return null;
        }
        return Clients::findOne($tokenHolder->client_id);
    }

    /**
     * @param $token
     * @return Clients|null
     */
    public function getClientByRefreshToken($token) {

        if(!$token) {
            return null;
        }

        /** @var ClientTokenHolder $tokenHolder */
        $tokenHolder = ClientTokenHolder::find()
            ->where(['refresh_token' => $token])
            ->one();
        if(!$tokenHolder) {
            return null;
        }
        return Clients::findOne($tokenHolder->client_id);
    }








}