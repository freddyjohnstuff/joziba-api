<?php

use yii\db\Migration;

/**
 * Class m240225_134323_alter_goods_helpers
 */
class m240225_134323_alter_goods_helpers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%goods_helpers}}',
            'fld_parameters',
            $this->string()->null()
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        try {
            $this->dropColumn('{{%goods_helpers}}', 'fld_parameters');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240225_134323_alter_goods_helpers cannot be reverted.\n";
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
        echo "m240225_134323_alter_goods_helpers cannot be reverted.\n";

        return false;
    }
    */
}
