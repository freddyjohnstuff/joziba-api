<?php

use yii\db\Migration;

/**
 * Class m240222_030651_alter_goods_category
 */
class m240222_030651_alter_goods_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%goods_category}}',
            'fld_breadcrumb',
            $this->string()->null()
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropColumn('{{%goods_category}}', 'fld_breadcrumb');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240222_030651_alter_goods_category cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }

}
