<?php

namespace app\api\modules\v1\components\transactions;

use Yii;
use yii\helpers\Json;
use app\models\Transaction;
use yii\helpers\ArrayHelper;
use app\modules\cards\components\CardsHelper;
use app\modules\cards\components\DataCollector;
use app\api\modules\v1\components\transactions\TransactionFields;
use Throwable;

class Soldo extends \yii\base\Component
{
    public const ENDPOINT_AUTH = 'https://api.soldo.com/oauth/authorize';
    public const ENDPOINT_TRANSACTIONS = 'https://api.soldo.com/business/v1/transactions';


    /**
     * client
     *
     * @var \GuzzleHttp\Client
     */
    public $client = null;
    public $token = null;


    public function init()
    {
        $this->token = $this->getToken();
    }
    /**
     * Получит токен
     *
     * @return void
     */
    public function getToken()
    {
        $response = $this->client->request(
            'POST',
            self::ENDPOINT_AUTH,
            [
                'form_params' => [
                    'client_id' => Yii::$app->params['soldo_client_id'],
                    'client_secret' => Yii::$app->params['soldo_client_secret'],
                ]
            ]
        );
        $code = $response->getStatusCode();
        $result = Json::decode($response->getBody()->getContents(), false);
        return $result->access_token;
    }
    /**
     * Получит все транзакции за последние 40 дней
     *
     * @return array
     */
    public function getTransactions(int $page = 0)
    {
        $transactions = [];
        $response = $this->client->request(
            'GET',
            self::ENDPOINT_TRANSACTIONS,
            [
                'query' => [
                    'fromDate' => date("Y-m-d", time() - 3600 * 24 * 40),
                    'toDate' => date("Y-m-d"),
                    'p' => $page
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]
        );
        $code = $response->getStatusCode();
        if (200 === $code) {
            $result = Json::decode($response->getBody()->getContents(), false);
            $transactions = ArrayHelper::merge($transactions, $result->results);
            if ($result->pages > ++$page) {
                $transactions = ArrayHelper::merge($transactions, $this->getTransactions($page));
            }
        }
        return ArrayHelper::toArray($transactions);
    }

    /**
     * Импортирует транзакции в базу
     *
     * @param array $allTransactions
     *
     * @return array
     */
    public function importTransactions(array $allTransactions)
    {
        $transactions = $this->filterExistingTransactions($allTransactions);
        $txs = []; //транзакции сохраненные
        foreach ($transactions as $transaction) {
            $data = (Yii::createObject(
                ['class' => DataCollector::class],
                [(new TransactionFields()), CardsHelper::flattenAssoc($transaction)]
            ))->collect();
            try {
                $tx = new Transaction();
                if ($tx->load($data, '') && $tx->save()) {
                    $txs[] = $tx;
                    Yii::info('Получена транзакция soldo ' . $tx->description . ' ' . $tx->amount_eur . ' EUR', 'soldo');
                } else {
                    Yii::error('Ошибка в сохранении транзакции: ' . json_encode($tx->errors), 'soldo');
                }
            } catch (Throwable $e) {
                Yii::error('Ошибка в получении транзакции: ' . $e->getMessage(), 'soldo');
            }
        }
        return $txs;
    }

    /**
     * Отсеять из массива созданные транзакции
     *
     * @param array $transactions
     *
     * @return array
     */
    public function filterExistingTransactions(array $transactions)
    {
        $incomeUids = ArrayHelper::getColumn($transactions, 'id', $keepKeys = true);
        $existsUids = Transaction::find()
            ->select('payment_uid')
            ->where(['in', 'payment_uid', $incomeUids])
            ->column();
        $newUids = array_diff($incomeUids, $existsUids);
        $newTransactions = array_filter($transactions, fn ($tx) => in_array($tx['id'], $newUids));
        return $newTransactions;
    }
}
