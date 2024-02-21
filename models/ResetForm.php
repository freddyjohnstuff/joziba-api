<?php

namespace app\models;

use yii\base\Model;

class ResetForm extends Model
{

    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            [['email'], 'required'],
            [['email'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }


    /**
     * @return false
     */
    public function reset()
    {

        // Validate
        if (!$this->validate()) {
            return false;
        }

        $client = Clients::find()->where(['email' => $this->email])->one();
        if(empty($client)) {
            $this->addError('email', 'User by this email exist');
            return false;
        }

        $hash =  $client->reset_access_token;
        $this->updateHash($client);

        $sent = \Yii::$app->mailer->compose('reset/remind', ['hash' => $hash])
            ->setFrom(['asadova.mtt@gmail.com' => 'Asadova MTT'])
            ->setTo('displaer@yandex.ru')
            ->setSubject('Reset Password to Joziba Online System')
            ->send();

        return ($sent);

    }



    private function updateHash($client) {
        Clients::updateAll(['reset_access_token' => sha1($client->password . time())], ['id' => $client->id]);
    }

}