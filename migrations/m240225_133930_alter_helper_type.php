<?php

use yii\db\Migration;

/**
 * Class m240225_133930_alter_helper_type
 */
class m240225_133930_alter_helper_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%helper_type}}', 'fld_parameters');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->addColumn('{{%helper_type}}', 'fld_parameters', $this->string()->null());
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240225_133930_alter_helper_type cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }
}
