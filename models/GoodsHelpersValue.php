<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_helpers_value".
 *
 * @property int $id
 * @property int $service_goods_id
 * @property int $helper_id
 * @property string $value
 *
 * @property GoodsHelpers $helper
 * @property ServiceGoods $serviceGoods
 */
class GoodsHelpersValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_helpers_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_goods_id', 'helper_id'], 'required'],
            [['id', 'service_goods_id', 'helper_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['helper_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsHelpers::class, 'targetAttribute' => ['helper_id' => 'id']],
            [['service_goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceGoods::class, 'targetAttribute' => ['service_goods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_goods_id' => Yii::t('app', 'Service Goods ID'),
            'helper_id' => Yii::t('app', 'Helper ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * Gets query for [[Helper]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelper()
    {
        return $this->hasOne(GoodsHelpers::class, ['id' => 'helper_id']);
    }

    /**
     * Gets query for [[ServiceGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceGoods()
    {
        return $this->hasOne(ServiceGoods::class, ['id' => 'service_goods_id']);
    }
}
