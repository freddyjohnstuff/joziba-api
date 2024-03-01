<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taj_cities".
 *
 * @property int $id
 * @property int|null $state
 * @property string $slug
 * @property string $name
 * @property string $label
 * @property int|null $order
 */
class TajCities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taj_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state', 'order'], 'integer'],
            [['slug', 'name', 'label'], 'required'],
            [['slug', 'name', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'state' => Yii::t('app', 'State'),
            'slug' => Yii::t('app', 'Slug'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'order' => Yii::t('app', 'Order'),
        ];
    }
}
