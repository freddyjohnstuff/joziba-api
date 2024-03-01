<?php

use yii\db\Migration;

/**
 * Class m240301_050947_seed_ads_status
 */
class m240301_050947_seed_ads_status extends Migration
{

    public $tableName = '{{%ads_status}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            [1, 'Draft'], /* Created and editing */
            [2, 'Published'], /* Published and ready for viewing to other peopl e*/
            [3, 'Expired'], /* Expired publishing period, can view by straight link, not in global listing and in search result, owner can republish */
            [4, 'Reported'], /* Has has less jr equal to 3 report  */
            [5, 'Blocked'], /* Override reports and got blocked, can view only admin and owner */
            [6, 'Removed'], /* Removed by admin or owner */
        ];

        $this->batchInsert(
            $this->tableName,
            [
                'id',
                'name',
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
            $this->truncateTable($this->tableName);
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240301_050947_seed_ads_status cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }
    }
}
