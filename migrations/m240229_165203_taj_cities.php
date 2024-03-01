<?php

use yii\db\Migration;

/**
 * Class m240229_165203_taj_cities
 */
class m240229_165203_taj_cities extends Migration
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
            '{{%taj_cities}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'state' => $this->integer()->null(),
                'slug' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'label' => $this->string()->notNull(),
                'order' => $this->integer()->null(),
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable('{{%taj_cities}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240229_165203_taj_cities cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }

}
