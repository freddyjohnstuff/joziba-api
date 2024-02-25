<?php

use yii\db\Migration;

/**
 * Class m240225_112003_alter_media
 */
class m240225_112003_alter_media extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%media}}',
            'client_id',
            $this->integer()->notNull()
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropColumn('{{%media}}', 'client_id');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240225_112003_alter_media cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }
}
