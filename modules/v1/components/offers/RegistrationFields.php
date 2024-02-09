<?php

namespace app\api\modules\v1\components\offers;

use ArrayObject;
use app\api\modules\v1\components\offers\FieldsInterface;

/**
 * Класс полей для события регистрация
 */
class RegistrationFields extends ArrayObject implements FieldsInterface
{
    /**
     * Названия полей которые не будут перезаписаны данными из запроса, а будут определены на сервере
     *
     * @return array
     */
    public function protectedFields(): array
    {
        return  ['password'];
    }

    public function __construct()
    {
        $input = [
            'event_id' => null,
            'postback_event_id' => null,
            'offer_visit_event_id' => \app\api\modules\v1\components\offers\DataCollector::getOfferVisitEventIdBySession(),
            'firstname' => '',
            'lastname' => '',
            'email' => '',
            'password' => \Yii::$app->getSecurity()->generateRandomString(8),
            'phone' => '',
            'phonecc' => '',
            't3' => null,
            'campid' => null,
            'hoster' => '',

        ];

        parent::__construct($input);
    }

    /**
     * Обработки для значиений
     * При получении значений при необходимости дополнительной обработки, для ключа можно указать коллбэк
     * внутри которого произвести манипуляцию с данными.
     * @return array
     */
    public function processors($key): callable
    {
        $functions = [
            'event_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'postback_event_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'offer_visit_event_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'campid' => fn ($data) => ($data !== null) ? (int)$data : null,
        ];
        return  $functions[$key] ?? fn ($data) => $data;
    }

    /**
     * Метод возвращает для полей возможные алиасы во входящих данных
     *
     * @return array
     */
    public function aliases(): array
    {
        return [];
    }
}
