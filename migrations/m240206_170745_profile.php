<?php

use yii\db\Migration;

/**
 * Class m240206_170745_profile
 */
class m240206_170745_profile extends Migration
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
            '{{%profile}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'client_id' => $this->integer()->notNull(),
                'name' => $this->string()->notNull()
            ],
            $tableOptions
        );

        $this->createIndex('profile_client_id_idx', '{{%profile}}', ['client_id']);

        $this->addForeignKey(
            'profile_client_id_fk',
            '{{%profile}}',
            ['client_id'],
            '{{%clients}}',
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
            $this->dropForeignKey('profile_client_id_fk', '{{%profile}}');
            $this->dropIndex('profile_client_id_idx', '{{%profile}}');
            $this->dropTable('{{%profile}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240206_170745_profile cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }
}
