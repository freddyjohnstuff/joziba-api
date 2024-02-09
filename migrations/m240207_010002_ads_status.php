<?php

use yii\db\Migration;

/**
 * Class m240207_010002_ads_status
 */
class m240207_010002_ads_status extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%ads_status}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'name' => $this->string()->notNull()
            ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        try {
            $this->dropTable('{{%ads_status}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "ads_status cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }
}
