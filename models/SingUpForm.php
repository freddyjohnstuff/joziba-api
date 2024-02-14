<?php

namespace app\models;

use yii\base\Model;

class SingUpForm extends Model
{

    public $email;
    public $phone;
    public $password1 ;
    public $password2 ;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            // username and password are both required
            [['email', 'phone', 'password1', 'password2'], 'required'],
            [['email', 'phone', 'password1', 'password2'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            // password is validated by validatePassword()
            [['password1'], 'compare', 'compareAttribute' => 'password2' ],
            ['password1', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $uppercase = preg_match('@[A-Z]@', $this->password1);
            $lowercase = preg_match('@[a-z]@', $this->password1);
            $number    = preg_match('@[0-9]@', $this->password1);

            if(!$uppercase || !$lowercase || !$number || strlen($this->password1) < 8) {
                $this->addError($attribute, 'Incorrect password(Uppercase, lowercase, digits, 8 symbols)');
            }
        }
    }

    /**
     * @return false
     */
    public function singup()
    {

        // Validate
        if (!$this->validate()) {
            return false;
        }

        // EXIST
        $exist = Clients::find()->where(['OR', ['email' => $this->email], ['phone' => $this->phone]])->exists();
        if($exist) {
            $this->addError('email', 'User by this email/phone exist');
        }

        $client = new Clients();
        $client->email = $this->email;
        $client->phone = $this->phone;
        $client->password = sha1($this->email . '|' . $this->password1);
        $client->reset_access_token = sha1($client->password . time());
        $client->remove_account_token = sha1('DELETE' . time() . $client->password);

        if(!$client->save()) {
            return false;
        }
        return $client->id;
    }

}