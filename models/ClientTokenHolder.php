<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_token_holder".
 *
 * @property int $id
 * @property int $client_id
 * @property string $access_token
 * @property int $access_token_expired
 * @property string $refresh_token
 * @property int $refresh_token_expired
 *
 * @property Clients $client
 */
class ClientTokenHolder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_token_holder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'access_token', 'access_token_expired', 'refresh_token', 'refresh_token_expired'], 'required'],
            [['client_id', 'access_token_expired', 'refresh_token_expired'], 'integer'],
            [['access_token', 'refresh_token'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'access_token' => Yii::t('app', 'Access Token'),
            'access_token_expired' => Yii::t('app', 'Access Token Expired'),
            'refresh_token' => Yii::t('app', 'Refresh Token'),
            'refresh_token_expired' => Yii::t('app', 'Refresh Token Expired'),
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::class, ['id' => 'client_id']);
    }
}
