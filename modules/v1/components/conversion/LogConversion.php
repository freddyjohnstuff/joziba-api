<?php


namespace app\api\modules\v1\components\conversion;

use app\models\ConversionLog;
use app\models\ConversionStatus;

class LogConversion implements Logger
{
    /**
     * @param $data
     */
    public function addLog($data)
    {
        $log = new ConversionLog();
        $log->type = $data['type'] ?? '';
        $log->query_string = $data['request'] ?? '';
        $log->event_id = $data['postback_id'] ?? '';
        $log->created_at = date("Y-m-d H:i:s");
        $log->response = $data['response'] ?? '';
        $log->pixel_id = $data['pixel_id'] ?? '';
        $log->status_id = $data['status_id'] ?? ConversionStatus::ERROR;
        $log->save(false);
    }
}
