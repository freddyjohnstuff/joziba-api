<?php
namespace app\api\modules\v1\components\conversion;

interface ConversionApi
{
    public function send(Logger $logger);
}