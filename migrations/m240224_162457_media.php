<?php

use yii\db\Migration;

/**
 * Class m240224_162457_media
 */
class m240224_162457_media extends Migration
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
            '{{%media}}',
            [
                'id' => $this->integer()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
                'target_entity' => $this->string()->null()->comment('ads,category,client'),
                'target_id' => $this->integer()->null(),
                'media_url' => $this->string()->null(),
                'media_path' => $this->string()->null(),
                'created_at' => $this->timestamp()->null()->defaultExpression('CURRENT_TIMESTAMP'),
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
            $this->dropTable('{{%media}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240224_162457_media cannot be reverted.\n";
            print( $e->getMessage() );
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
        echo "m240224_162457_media cannot be reverted.\n";

        return false;
    }
    */
}
