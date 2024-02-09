<?php

use yii\db\Migration;

/**
 * Class m240207_040622_goods_category
 */
class m240207_040622_goods_category extends Migration
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
            '{{%goods_category}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'parent_id' => $this->integer()->notNull(),
                'fld_key' => $this->string()->notNull(),
                'fld_label' => $this->string()->notNull(),
                'fld_order' => $this->integer()->notNull()->defaultValue(0),
            ],
            $tableOptions
        );

        $this->createIndex('goods_category_fld_key_unq', '{{%goods_category}}', 'fld_key',true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        try {
            $this->dropIndex('goods_category_fld_key_unq', '{{%goods_category}}');
            $this->dropTable('{{%goods_category}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240207_040622_goods_category cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }
}
