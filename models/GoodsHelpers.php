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
 * This is the model class for table "goods_helpers".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type_id
 * @property string $fld_name
 * @property string $fld_label
 * @property string $fld_default
 *
 * @property GoodsCategory $category
 * @property GoodsHelpersValue[] $goodsHelpersValues
 * @property HelperType $type
 */
class GoodsHelpers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_helpers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'type_id', 'fld_name', 'fld_label', 'fld_default'], 'required'],
            [['id', 'category_id', 'type_id'], 'integer'],
            [['fld_name', 'fld_label', 'fld_default'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelperType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'fld_name' => Yii::t('app', 'Fld Name'),
            'fld_label' => Yii::t('app', 'Fld Label'),
            'fld_default' => Yii::t('app', 'Fld Default'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[GoodsHelpersValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsHelpersValues()
    {
        return $this->hasMany(GoodsHelpersValue::class, ['helper_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(HelperType::class, ['id' => 'type_id']);
    }
}
