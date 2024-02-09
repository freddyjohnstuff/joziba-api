<?php


namespace app\api\modules\v1\components\logs;

use app\models\OfferLinks;

class TrackComponent
{
    public $link_id;
    /**
     * @var bool
     */
    public $commit = false;
    /**
     * @var array
     */
    public $logDataFields = [
        'uclick',
        'company_key',
        'url',
        'url2',
        'status',
        'phpsessid',
        'click_id',
    ];
    /**
     * @var array
     */
    public $logDataArray;
    /**
     * @var TrackComponent
     */
    private static $instance;

    protected function __construct()
    {
    }
    protected function __clone()
    {
    }
    protected function __wakeup()
    {
    }

    public function setLogId($log_id)
    {
        if ($this->isCommit()) {
            OfferLinks::updateAll(['log_id' => $log_id], ['id' => $this->link_id]);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public function isCommit()
    {
        return $this->commit;
    }


    public function log($key, $value)
    {
        if (isset($this->logDataArray[$key])) {
            $this->logDataArray[$key . '_copy_' . time()] = $this->logDataArray[$key];
        }
        $this->logDataArray[$key] = $value;
    }


    public function commit($writeReadTime = false)
    {
        $log = new OfferLinks();
        foreach ($this->logDataFields as $fld) {
            $log->$fld = (isset($this->logDataArray[$fld]) ? $this->logDataArray[$fld] : '');
        }

        if (empty($log->status)) {
            $log->status = 1;
        }
        $log->at_write = time();
        if ($writeReadTime) {
            $log->at_read = time();
        }
        $this->commit = $log->save(false);
        $this->link_id = $log->id;
    }


    public function getUrlByUClick($key, $company_key)
    {
        $data = OfferLinks::find()
            ->where(['uclick' => $key])
            ->andWhere(['company_key' => $company_key])
            ->andWhere(['status' => [1, 2]])
            ->one();
        if ($data) {
            $updateData = OfferLinks::findOne($data->id);
            $updateData->status = 2;
            $updateData->at_read = time();
            $updateData->save(false);
            unset($updateData);
            return $data['url'];
        } else {
            return $key;
        }
    }
}
