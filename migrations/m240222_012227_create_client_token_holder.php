<?php

use yii\db\Migration;

/**
 * Class m240222_012227_create_client_token_holder
 */
class m240222_012227_create_client_token_holder extends Migration
{

    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%client_token_holder}}',
            [
                'id'                    => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'client_id'            => $this->integer()->notNull(),
                'access_token'          => $this->string()->null(),
                'access_token_expired'  => $this->integer()->notNull(),
                'refresh_token'         => $this->string()->notNull(),
                'refresh_token_expired' => $this->integer()->null(),
            ],
            $tableOptions
        );


        $this->createIndex('client_token_holder_client_id_idx', '{{%client_token_holder}}', 'client_id');
        $this->addForeignKey(
            'client_token_holder_client_fk',
            '{{%client_token_holder}}',
            ['client_id'],
            '{{%clients}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );

    }

    public function safeDown()
    {
        try {
            $this->dropForeignKey('client_token_holder_client_fk', '{{%client_token_holder}}');
            $this->dropIndex('client_token_holder_client_id_idx', '{{%client_token_holder}}');
            $this->dropTable('{{%client_token_holder}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240204_125757_clients cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }

    }
}
