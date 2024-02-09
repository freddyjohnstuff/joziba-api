<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $client_id
 * @property string $name
 *
 * @property Clients $client
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'name'], 'required'],
            [['id', 'client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'name' => Yii::t('app', 'Name'),
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
