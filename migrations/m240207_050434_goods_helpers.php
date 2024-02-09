<?php

use yii\db\Migration;

/**
 * Class m240207_050434_goods_helpers
 */
class m240207_050434_goods_helpers extends Migration
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
            '{{%goods_helpers}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'category_id' => $this->integer()->notNull(),
                'type_id' => $this->integer()->notNull(),
                'fld_name' => $this->string()->notNull(),
                'fld_label' => $this->string()->notNull(),
                'fld_default' => $this->string()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('goods_helpers_category_id_idx', '{{%goods_helpers}}', 'category_id');
        $this->createIndex('goods_helpers_type_id_idx', '{{%goods_helpers}}', 'type_id');

        $this->addForeignKey(
            'goods_helpers_category_id_fk',
            '{{%goods_helpers}}',
            ['category_id'],
            '{{%goods_category}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            'goods_helpers_type_id_fk',
            '{{%goods_helpers}}',
            ['type_id'],
            '{{%helper_type}}',
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
            $this->dropForeignKey('goods_helpers_type_id_fk', '{{%goods_helpers}}');
            $this->dropForeignKey('goods_helpers_category_id_fk', '{{%goods_helpers}}');

            $this->dropIndex('goods_helpers_type_id_idx', '{{%goods_helpers}}');
            $this->dropIndex('goods_helpers_category_id_idx', '{{%goods_helpers}}');

            $this->dropTable('{{%goods_helpers}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "goods_category cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }
}
