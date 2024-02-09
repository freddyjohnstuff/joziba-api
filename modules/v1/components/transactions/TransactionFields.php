<?php

namespace app\api\modules\v1\components\transactions;

use Yii;
use ArrayObject;
use yii\helpers\Json;
use app\models\TransactionsExpenditure;
use app\modules\cards\base\FieldsInterface;

/**
 * Класс полей для события
 */
class TransactionFields extends ArrayObject implements FieldsInterface
{
    /**
     *  Названия полей которые не будут перезаписаны данными из запроса, а будут определены на сервере
     *
     * @return array
     */
    public function protectedFields(): array
    {
        return ['payment_service_id', 'transaction_expenditure_id'];
    }

    /**
     * В конструкторе описываем поля и значения по-умолчанию
     *
     * @return void
     */
    public function __construct()
    {
        $input = [
            'transaction_type_id' => 12,
            'payment_service_id' => Yii::$app->params['soldo_transaction_type_id'],
            'transaction_status_id' => 6,
            'transaction_expenditure_id' => TransactionsExpenditure::OTHER,
            'amount_eur_initial' => null,
            'amount_eur' => null,
            'card_number' => null,
            'payment_uid' => null,
            'extra' => null,
            'note' => null,
            'description' => null,
            'deleted' => null,
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
            'transaction_type_id' => fn ($data) => $this->getTypeId($data),
            'transaction_status_id' => fn ($data) => $this->getStatusId($data),
            'extra' => fn ($data, $context) => Json::encode($context),
        ];
        return  $functions[$key] ?? function ($data) {
            return $data;
        };
    }

    /**
     * Метод возвращает для полей возможные алиасы во входящих данных
     *
     * @return array
     */
    public function aliases(): array
    {
        $aliases = [
            'amount_eur_initial' => ['amount'],
            'amount_eur' => ['amount'],
            'card_number' => ['wallet_id'],
            'payment_uid' => ['id'],
            'extra' => [null],
            'note' => ['notes'],
            'description' => ['merchant_name'],
        ];
        return $aliases;
    }

    public function getTypeId($data)
    {
        $typeId = 12;
        switch ($data) {
            case "Payment":
                $typeId = 2;
                break;
            case "Refund":
                $typeId = 6;
                break;
            case "Load":
                $typeId = 7;
                break;
            case "Transfer":
            case "Wiretransfer":
                $typeId = 8;
                break;
            case "Conversion":
                $typeId = 13;
                break;
            case "Withdrawal":
                $typeId = 14;
                break;
            case "Billing":
            case "RecurringBilling":
                $typeId = 15;
                break;
            case "LoadReversal":
            case "SoldoActivity":
            case "SoldoCreditOperation":
            case "SoldoDebitOperation":
            case "NotRecognized":
            default:
                $typeId = 12;
                break;
        }
        return $typeId;
    }

    public function getStatusId($data)
    {
        $statusId = 6;
        switch ($data) {
            case "Authorised":
                $statusId = 1;
                break;
            case "Settled":
                $statusId = 4;
                break;
            case "Cancelled":
                $statusId = 5;
                break;
            case "Refunded":
                $statusId = 3;
                break;
            case "Declined":
                $statusId = 2;
                break;
            case "DisputeFailed":
            case "DisputeOpened":
            case "DisputeWon":
            case "Unknown":
            default:
                $statusId = 6;
                break;
        }
        return $statusId;
    }
}
