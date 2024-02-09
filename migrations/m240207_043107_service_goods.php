<?php

use yii\db\Migration;

/**
 * Class m240207_043107_service_goods
 */
class m240207_043107_service_goods extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%service_goods}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'category_id' => $this->integer()->notNull(),
                'type_id' => $this->integer()->notNull(),
                'ads_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('service_goods_category_id_idx', '{{%service_goods}}', 'category_id');
        $this->createIndex('service_goods_type_id_idx', '{{%service_goods}}', 'type_id');
        $this->createIndex('service_goods_ads_id_idx', '{{%service_goods}}', 'ads_id');

        $this->addForeignKey(
            'service_goods_category_id_fk',
            '{{%service_goods}}',
            ['category_id'],
            '{{%goods_category}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );



        /*$this->addForeignKey(
            'service_goods_type_id_fk',
            '{{%service_goods}}'
        );*/

        $this->addForeignKey(
            'service_goods_ads_id_fk',
            '{{%service_goods}}',
            ['ads_id'],
            '{{%ads}}',
            ['id'],
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


            $this->dropForeignKey('service_goods_category_id_fk', '{{%service_goods}}');
            /*$this->dropForeignKey('service_goods_type_id_fk', '{{%service_goods}}');*/
            $this->dropForeignKey('service_goods_ads_id_fk', '{{%service_goods}}');

            $this->dropIndex('service_goods_category_id_idx', '{{%service_goods}}');
            $this->dropIndex('service_goods_type_id_idx', '{{%service_goods}}');
            $this->dropIndex('service_goods_ads_id_idx', '{{%service_goods}}');

            $this->dropTable('{{%service_goods}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "goods_category cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }

}
