<?php

use yii\db\Migration;

/**
 * Class m240207_051421_goods_helpers_value
 */
class m240207_051421_goods_helpers_value extends Migration
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
            '{{%goods_helpers_value}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'service_goods_id' => $this->integer()->notNull(),
                'helper_id' => $this->integer()->notNull(),
                'value' => $this->string()->notNull()->defaultValue(''),
            ],
            $tableOptions
        );

        $this->createIndex('goods_helpers_value_service_goods_id_idx', '{{%goods_helpers_value}}', 'service_goods_id');
        $this->createIndex('goods_helpers_value_helper_id_idx', '{{%goods_helpers_value}}', 'helper_id');

        $this->addForeignKey(
            'goods_helpers_value_service_goods_id_fk',
            '{{%goods_helpers_value}}',
            ['service_goods_id'],
            '{{%service_goods}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            'goods_helpers_value_helper_id_fk',
            '{{%goods_helpers_value}}',
            ['helper_id'],
            '{{%goods_helpers}}',
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
            $this->dropForeignKey('goods_helpers_value_service_goods_id_fk', '{{%goods_helpers_value}}');
            $this->dropForeignKey('goods_helpers_value_helper_id_fk', '{{%goods_helpers_value}}');

            $this->dropIndex('goods_helpers_value_service_goods_id_idx', '{{%goods_helpers_value}}');
            $this->dropIndex('goods_helpers_value_helper_id_idx', '{{%goods_helpers_value}}');

            $this->dropTable('{{%goods_helpers_value}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "goods_category cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }



}
