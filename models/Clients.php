<?php

namespace app\models;

use Yii;
/**
 * @OA\\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Description removed for better illustration of structure.",
 * )
 */


/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string|null $access_token
 * @property string|null $renew_token
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
            [['id', 'email', 'phone', 'password'], 'required'],
            [['id'], 'integer'],
            [['email', 'phone', 'password'], 'string', 'max' => 100],
            [['access_token', 'renew_token'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'access_token' => Yii::t('app', 'Access Token'),
            'renew_token' => Yii::t('app', 'Renew Token'),
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
