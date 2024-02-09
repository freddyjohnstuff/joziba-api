<?php

namespace app\api\modules\v1\components\offers;

use ArrayObject;
use app\api\modules\v1\components\offers\FieldsInterface;

/**
 * Класс полей дополнительных для отправки партнеру данных
 */
class AdditionalFields extends ArrayObject implements FieldsInterface
{
    /**
     * Названия полей которые не будут перезаписаны данными из запроса, а будут определены на сервере
     *
     * @var array
     */
    public function protectedFields(): array
    {
        return [];
    }

    public function __construct()
    {
        $input = [
            'binom_click_id' => null,
            'click_id' => null,
            'payout' => null,
            'prelanding' => '',
            'user_ip' => \app\api\modules\v1\components\offers\DataCollector::getUserIpFromProxy(),
        ];

        parent::__construct($input);
    }

    /**
     * Обработки для значиений
     * При получении значений при необходимости дополнительной обработки, для ключа можно указать коллбэк
     * внутри которого произвести манипуляцию с данными.
     * @return void
     */
    public function processors($key): callable
    {
        $functions = [
            'event_id' => fn ($data) => ($data !== null) ? (int)$data : null,
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
        return [
            'binom_click_id' => ['click_id'],
            'click_id' => ['binom_click_id'],
            'prelanding' => ['preland_url'],
            'user_ip' => ['ip'],
        ];
    }
}
