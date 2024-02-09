<?php


namespace app\api\modules\v1\components\conversion\facebook;

use app\api\modules\v1\components\conversion\LogConversion;
use app\api\modules\v1\components\conversion\Sender;
use app\models\ConversionQueue;

class FacebookConversionSender implements Sender
{
    /**
     * @param ConversionQueue $model
     * @return bool
     * @throws \ErrorException
     */
    public static function send(ConversionQueue $model) : bool
    {
        $logger = new LogConversion();
        $data = (new FacebookPrepareData($model))->prepare($logger);
        if (empty($data)) {
            return false;
        } else {
            (new FacebookApi($data))->send($logger);
            return true;
        }
    }
}
