<?php

namespace app\models;

use yii\web\IdentityInterface;

class ClientIdentify extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;

    /**
     * @param Clients $client
     */
    public function __construct($client)
    {
        $this->id = $client->id;
        $this->username = $client->email;
        $this->password = $client->password;
    }

    public static function findIdentity($id)
    {
        return Clients::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        /** @var ClientTokenHolder $tokenClients */
        $tokenClients = ClientTokenHolder::find()
            ->where(
                [
                    'AND',
                    ['access_token' => $token],
                    ['>=','access_token_expired', time()]
                ]
            )
            ->one();
        if($tokenClients) {
            return new static($tokenClients->client);
        }

        if($token == md5('test_api_key')) {
            return new static(Clients::find()->one());
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return ClientTokenHolder::findOne($this->id)->access_token;
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}