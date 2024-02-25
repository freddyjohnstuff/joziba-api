<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string|null $target_entity ads,category,client
 * @property int|null $target_id
 * @property string|null $media_url
 * @property string|null $media_path
 * @property string|null $created_at
 * @property int $client_id
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_id', 'client_id'], 'integer'],
            [['created_at'], 'safe'],
            [['client_id'], 'required'],
            [['target_entity', 'media_url', 'media_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'target_entity' => Yii::t('app', 'Target Entity'),
            'target_id' => Yii::t('app', 'Target ID'),
            'media_url' => Yii::t('app', 'Media Url'),
            'media_path' => Yii::t('app', 'Media Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'client_id' => Yii::t('app', 'Client ID'),
        ];
    }
}
