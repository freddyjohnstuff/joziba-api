<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_goods".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type_id
 * @property int $ads_id
 *
 * @property Ads $ads
 * @property GoodsCategory $category
 * @property GoodsHelpersValue[] $goodsHelpersValues
 */
class ServiceGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id', 'ads_id'], 'required'],
            [['category_id', 'type_id', 'ads_id'], 'integer'],
            [['ads_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::class, 'targetAttribute' => ['ads_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsCategory::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'ads_id' => Yii::t('app', 'Ads ID'),
        ];
    }

    /**
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasOne(Ads::class, ['id' => 'ads_id']);
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
        return $this->hasMany(GoodsHelpersValue::class, ['service_goods_id' => 'id']);
    }


    public function getGoodsHelpersValuesWithLabels() {

        $list = $this->getGoodsHelpersValues()->all();
        $_list = [];
        foreach ($list as $item) {
            $_item = $item->toArray();
            $_item['helper_name'] = $item->helper;
            unset($_item['helper_name']['fld_parameters']);
            $_list[] = $_item;
        }

        return $_list;
    }



}
