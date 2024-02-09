<?php

use yii\db\Migration;

/**
 * Class m240207_031420_ads
 */
class m240207_031420_ads extends Migration
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
            '{{%ads}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'client_id' => $this->integer()->notNull(),
                'status_id' => $this->integer()->notNull(),
                'published' => $this->integer(100)->notNull()->defaultValue(0),
                'title' => $this->string()->notNull(),
                'description' => $this->text()->null(),
                'expired_date' => $this->date(),
                'publish_date' => $this->date(),
                'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->dateTime()->defaultValue(null),
                'expired_at' => $this->dateTime()->defaultValue(null),
            ],
            $tableOptions
        );

        $this->createIndex('ads_client_id_idx', '{{%ads}}', ['client_id']);
        $this->createIndex('ads_status_id_idx', '{{%ads}}', ['status_id']);

        $this->addForeignKey(
            'ads_client_id_fk',
            '{{%ads}}',
            ['client_id'],
            '{{%clients}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'ads_status_id_fk',
            '{{%ads}}',
            ['status_id'],
            '{{%ads_status}}',
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
            $this->dropForeignKey('ads_client_id_fk', '{{%ads}}');
            $this->dropForeignKey('ads_status_id_fk', '{{%ads}}');

            $this->dropIndex('ads_client_id_idx', '{{%ads}}');
            $this->dropIndex('ads_status_id_idx', '{{%ads}}');

            $this->dropTable('{{%ads}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "ads cannot be reverted.\n";
            print( $e->getMessage() );
            return false;
        }
    }


}
