<?php

use yii\db\Migration;

/**
 * Class m240227_084653_alter_goods_helpers
 */
class m240227_084653_alter_goods_helpers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->alterColumn('{{%goods_helpers}}',
            'fld_parameters',
            $this->text()->null()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->alterColumn(
                '{{%goods_helpers}}',
                'fld_parameters',
                $this->string()->notNull()
            );
        } catch (\yii\db\Exception $e) {
            echo "m240227_084653_alter_goods_helpers cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }


    }

}
