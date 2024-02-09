<?php


namespace app\api\modules\v1\components\logs;

use app\models\Log;
use yii\helpers\Json;

class LoggingComponent implements LoggingInterface
{
    public $id;
    /**
     * @var bool
     */
    public $commit = false;

    /**
     * @var array
     */
    public $logDataFields = [
        'ip',
        'ipv6',
        'ua',
        'referer',
        'referer_prelanding',
        'company_key',
        'campid',
        'manager_key',
        'language',
        'country',
        'city',
        'isp',
        'asn',
        'os',
        'browser',
        'external_uclick',
        'log_type',
        'detailed',
        'is_bot_passed'
    ];

    /**
     * @var array
     */
    public $logDataArray;

    /**
     * @var LoggingComponent
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

    public static function getInstance() : LoggingComponent
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


    public function commit()
    {
        
        $this->logDataArray['at_datetime'] = date('Y-m-d H:i:s');
        // todo: JSON_ERROR_NONE
        $this->logDataArray['meta_data'] = json_encode($this->logDataArray, JSON_HEX_APOS | JSON_HEX_QUOT);

        $log = new Log();
        $log->at_datetime = $this->logDataArray['at_datetime'];
        $log->meta_data = $this->logDataArray['meta_data'];
        $log->detailed = Json::encode($log->detailed);
        
        foreach ($this->logDataFields as $fld) {
            $log->$fld = ($this->logDataArray[$fld] ?? '');
        }

        $this->commit = $log->save(false);
        $this->id = $log->id;
        TrackComponent::getInstance()->setLogId($this->id);
    }
}
