<?php

use yii\db\Migration;

/**
 * Class m240204_125757_clients
 */
class m240204_125757_clients extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%clients}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'email' => $this->string(100)->notNull(),
                'phone' => $this->string(100)->notNull(),
                'password' => $this->string(100)->notNull(),
                'access_token' => $this->string()->null(),
                'renew_token' => $this->string()->null(),
            ],
            $tableOptions
        );

        /*$this->alterColumn('{{%clients}}','id', 'INT(11) UNSIGNED NOT NULL FIRST AUTO_INCREMENT PRIMARY KEY');*/

    }

    public function safeDown()
    {
        try {
            $this->dropTable('{{%clients}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240204_125757_clients cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }

    }

}
