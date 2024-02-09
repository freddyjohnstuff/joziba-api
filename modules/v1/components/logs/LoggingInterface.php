<?php


namespace app\api\modules\v1\components\logs;

interface LoggingInterface
{
    public function log($key, $value);
    public function commit();
    public static function getInstance() : self;
}
