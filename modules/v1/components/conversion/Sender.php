<?php


namespace app\api\modules\v1\components\conversion;

use app\models\ConversionQueue;

interface Sender
{
    public static function send(ConversionQueue $model);
}
