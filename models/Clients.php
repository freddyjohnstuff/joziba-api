<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string|null $reset_access_token
 * @property string|null $remove_account_token
 *
 * @property Ads[] $ads
 * @property Profile[] $profiles
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'password'], 'required'],
            [['email', 'phone', 'password'], 'string', 'max' => 100],
            [['reset_access_token', 'remove_account_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'password' => Yii::t('app', 'Password'),
            'reset_access_token' => Yii::t('app', 'Reset Access Token'),
            'remove_account_token' => Yii::t('app', 'Remove Account Token'),
        ];
    }

    /**
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::class, ['client_id' => 'id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }
}
