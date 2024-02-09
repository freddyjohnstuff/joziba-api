<?php

use yii\db\Migration;

/**
 * Class m240207_065159_helper_type
 */
class m240207_050034_helper_type extends Migration
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
            '{{%helper_type}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'fld_key' => $this->string()->notNull(),
                'fld_name' => $this->string()->notNull(),
                'fld_parameters' => $this->string()->null(),
            ],
            $tableOptions
        );

        $this->createIndex('helper_type_fld_key_uniq', '{{%helper_type}}', 'fld_key', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        try {
            $this->dropIndex('helper_type_fld_key_uniq', '{{%helper_type}}');
            $this->dropTable('{{%helper_type}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "goods_category cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }


}
