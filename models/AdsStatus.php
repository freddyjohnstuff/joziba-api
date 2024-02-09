<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads_status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Ads[] $ads
 */
class AdsStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::class, ['status_id' => 'id']);
    }
}
