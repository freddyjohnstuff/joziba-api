<?php

use yii\db\Migration;

/**
 * Class m240221_144821_clients_alter
 */
class m240221_144821_clients_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->renameColumn('{{%clients}}', 'access_token', 'reset_access_token');
        $this->renameColumn('{{%clients}}', 'renew_token', 'remove_account_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->renameColumn('{{%clients}}', 'reset_access_token', 'access_token' );
            $this->renameColumn('{{%clients}}', 'remove_account_token', 'renew_token');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240221_144821_clients_alter cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240221_144821_clients_alter cannot be reverted.\n";

        return false;
    }
    */
}
