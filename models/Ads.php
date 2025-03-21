<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads".
 *
 * @property int $id
 * @property int $client_id
 * @property int $status_id
 * @property int $published
 * @property string $title
 * @property string|null $description
 * @property string|null $expired_date
 * @property string|null $publish_date
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $expired_at
 * @property int $city_id
 *
 * @property TajCities $city
 * @property Clients $client
 * @property ServiceGoods[] $serviceGoods
 * @property AdsStatus $status
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'status_id', 'title'], 'required'],
            [['client_id', 'status_id', 'published', 'city_id'], 'integer'],
            [['description'], 'string'],
            [['expired_date', 'publish_date', 'created_at', 'updated_at', 'expired_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => TajCities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdsStatus::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'status_id' => Yii::t('app', 'Status ID'),
            'published' => Yii::t('app', 'Published'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'expired_date' => Yii::t('app', 'Expired Date'),
            'publish_date' => Yii::t('app', 'Publish Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'expired_at' => Yii::t('app', 'Expired At'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(TajCities::class, ['id' => 'city_id']);
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

    /**
     * Gets query for [[ServiceGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceGoods()
    {
        return $this->hasMany(ServiceGoods::class, ['ads_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AdsStatus::class, ['id' => 'status_id']);
    }
}
