<?php

namespace app\models;

use Yii;

/*
 * @OA\\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Description removed for better illustration of structure.",
 * )
 */

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $fld_key
 * @property string $fld_label
 * @property int $fld_order
 * @property string|null $fld_breadcrumb
 *
 * @property GoodsHelpers[] $goodsHelpers
 * @property ServiceGoods[] $serviceGoods
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'fld_key', 'fld_label'], 'required'],
            [['parent_id', 'fld_order'], 'integer'],
            [['fld_key', 'fld_label', 'fld_breadcrumb'], 'string', 'max' => 255],
            [['fld_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'fld_key' => Yii::t('app', 'Fld Key'),
            'fld_label' => Yii::t('app', 'Fld Label'),
            'fld_order' => Yii::t('app', 'Fld Order'),
            'fld_breadcrumb' => Yii::t('app', 'Fld Breadcrumb'),
        ];
    }

    /**
     * Gets query for [[GoodsHelpers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsHelpers()
    {
        return $this->hasMany(GoodsHelpers::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[ServiceGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceGoods()
    {
        return $this->hasMany(ServiceGoods::class, ['category_id' => 'id']);
    }
}
