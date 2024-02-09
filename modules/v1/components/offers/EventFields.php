<?php

namespace app\api\modules\v1\components\offers;

use ArrayObject;
use app\api\modules\v1\components\offers\FieldsInterface;

/**
 * Класс полей для события
 */
class EventFields extends ArrayObject implements FieldsInterface
{

    /**
     *  Названия полей которые не будут перезаписаны данными из запроса, а будут определены на сервере
     *
     * @return array
     */
    public function protectedFields(): array
    {
        return ['useragent', 'raw_data'];
    }

    /**
     * В конструкторе описываем поля и значения по-умолчанию
     *
     * @return void
     */
    public function __construct()
    {
        $input = [
            'ts' => new \yii\db\Expression('NOW()'),
            'tstz' => new \yii\db\Expression('NOW()'),
            'campaign_id' => null,
            'buyer_id' => null,
            'country' => "US",
            'partner_id' => null,
            'session' => \app\api\modules\v1\components\offers\DataCollector::getCurrentSessionId(),
            'ip' => \app\api\modules\v1\components\offers\DataCollector::getUserIpFromProxy(),
            'binom_click_id' => null,
            'useragent' => \Yii::$app->request->useragent,
            'preland_url' => null,
            'googleua' => null,
            'cookiehash' => null,
            'raw_data' => (new \app\api\modules\v1\components\offers\RawData())->saveRawData(),
        ];

        parent::__construct($input);
    }

    /**
     * Обработки для значиений
     * При необходимости дополнительной обработки, полученного значения, для ключа можно указать коллбэк
     * внутри которого произвести манипуляцию с данными.
     * @return void
     */
    public function processors($key): callable
    {
        $functions = [
            'googleua' => fn ($data) => base64_decode($data),
            'cookiehash' => fn ($data) => base64_decode($data),
            'session' => fn ($data) => (string)$data,
            'campaign_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'buyer_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'partner_id' => fn ($data) => ($data !== null) ? (int)$data : null,
            'country' => fn ($data) => strtoupper((string)$data),
            'binom_click_id' => fn ($data) => (string)$data,
            'ts' => function ($data) {
                if (is_int($data)) {
                    return date("Y-m-d H:i:s", $data);
                }
            },
            'tstz' => function ($data) {
                if (is_int($data)) {
                    return date("Y-m-d H:i:s", $data);
                }
            },
            'key' => null,
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
        $aliases = [
            'preland_url' => ['prelanding'],
            'binom_click_id' => ['click_id'],
            'key' => ['treeId'],
        ];
        return $aliases;
    }
}
