<?php

use yii\db\Migration;

/**
 * Class m240303_134010_alter_media
 */
class m240303_134010_alter_media extends Migration
{

    public $tableName = '{{%media}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'file_name', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropColumn($this->tableName, 'file_name');
        } catch (\yii\db\Exception $e) {
            echo "m240303_134010_alter_media cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }

    }

}
