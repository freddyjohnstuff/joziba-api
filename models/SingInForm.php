<?php

namespace app\models;

use Yii;
use yii\base\Model;

/*
 * @OA\\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Description removed for better illustration of structure.",
 * )
 */

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SingInForm extends Model
{
    public $email;
    public $password;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || $this->hashPasswd($user->email,$user->password) === $this->hashPasswd($this->email,$this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return array|false
     */
    public function singIn()
    {
        $user = $this->getUser();
        if($user) {
            $client = ClientTokenHolder::find()->where(['client_id' => $user->id])->one();
            if(!$client) {
                $client = $this->createClientTokens($user);
            }
            $this->renewClientTokens($client);
            $this->prolongClientTokens($client);
            return $client->toArray();
        }
        return false;
    }

    public function logout($accessToken) {
        $client = ClientTokenHolder::find()->where(['access_token' => $accessToken])->one();
        if($client) {
            return $this->removeClientTokens($client);
        }
        return false;
    }

    /**
     * @return Clients|mixed|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Clients::find()->where(['email' => $this->email])->one();
        }

        return $this->_user;
    }

    private function hashPasswd($email, $password)
    {
        return sha1($email . '|' . $password);
    }

    /**
     * @param Clients $user
     * @return ClientTokenHolder
     */
    private function createClientTokens($user) {
        $tokens = new ClientTokenHolder();
        $tokens->client_id = $user->id;
        $tokens->access_token = sha1($user->email . $user->phone . time());
        $tokens->access_token_expired = time() + 1200;
        $tokens->refresh_token = sha1(md5($user->email . $user->phone . time() . rand(0,999)));
        $tokens->refresh_token_expired = time() + 24 * 3600;
        $tokens->save();
        return $tokens;
    }

    /**
     * @param ClientTokenHolder $clientTokens
     * @return void
     */
    private function prolongClientTokens($clientTokens) {
        ClientTokenHolder::updateAll(
            ['access_token_expired' => time() + 1200,
                'refresh_token_expired' => time() + 24 * 3600],
            ['id' => $clientTokens->id]
        );
    }

    /**
     * @param ClientTokenHolder $clientTokens
     * @return void
     */
    private function renewClientTokens($clientTokens) {
        ClientTokenHolder::updateAll(
            [
                'access_token' => sha1($clientTokens->client->email . $clientTokens->client->phone . time()),
                'refresh_token' => sha1(md5($clientTokens->client->email . $clientTokens->client->phone . time() . rand(0,999)))
            ],
            ['id' => $clientTokens->client->id]
        );
    }

    /**
     * @param $clientTokens
     * @return int
     */
    private function removeClientTokens($clientTokens) {
        return ClientTokenHolder::deleteAll(['id' => $clientTokens->id]);
    }
}
