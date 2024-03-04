<?php

use yii\db\Migration;

/**
 * Class m240304_002438_alter_ads
 */
class m240304_002438_alter_ads extends Migration
{
    public $tableName = '{{%ads}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn($this->tableName, 'city_id', $this->integer()->notNull()->defaultValue(1));
        $this->createIndex('ads_cities_idx',$this->tableName, ['city_id']);
        $this->addForeignKey(
            'ads_cities_fk',
            $this->tableName,
            'city_id',
            '{{%taj_cities}}',
            'id',
            'NO ACTION',
            'NO ACTION'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropForeignKey('ads_cities_fk',$this->tableName);
            $this->dropIndex('ads_cities_idx', $this->tableName);
            $this->dropColumn($this->tableName, 'city_id');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240304_002438_alter_ads cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }
}
