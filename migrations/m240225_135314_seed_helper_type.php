<?php

use yii\db\Migration;

/**
 * Class m240225_135314_seed_helper_type
 */
class m240225_135314_seed_helper_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            [1,'text','Text'],
            [2,'nomer','Nomer'],
            [3,'select','Select'],
            [4,'multiselect','Multiselect'],
            [5,'boolean','Boolean'],
            [6,'radio','Radio'],
            [7,'checkbox','Checkbox'],
            [8,'range','Range'],
        ];

        $this->batchInsert(
            '{{%helper_type}}',
            [
                'id',
                'fld_key',
                'fld_name'
            ],
            $data
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->truncateTable('{{%helper_type}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240225_135314_seed_helper_type cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }
}
