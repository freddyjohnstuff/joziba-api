<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "helper_type".
 *
 * @property int $id
 * @property string $fld_key
 * @property string $fld_name
 *
 * @property GoodsHelpers[] $goodsHelpers
 */
class HelperType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'helper_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fld_key', 'fld_name'], 'required'],
            [['fld_key', 'fld_name'], 'string', 'max' => 255],
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
            'fld_key' => Yii::t('app', 'Fld Key'),
            'fld_name' => Yii::t('app', 'Fld Name'),
        ];
    }

    /**
     * Gets query for [[GoodsHelpers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsHelpers()
    {
        return $this->hasMany(GoodsHelpers::class, ['type_id' => 'id']);
    }
}
