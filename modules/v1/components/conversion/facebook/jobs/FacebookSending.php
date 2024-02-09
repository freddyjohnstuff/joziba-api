<?php
namespace app\api\modules\v1\components\conversion\facebook\jobs;

use app\api\modules\v1\components\conversion\facebook\FacebookConversionSender;
use app\models\ConversionQueue;
use app\models\ConversionStatusQueue;
use yii\base\BaseObject;

class FacebookSending extends BaseObject implements \yii\queue\JobInterface
{
    public int $idQueue;
    /* @var ConversionQueue $model */
    protected $model;

    public function execute($queue)
    {
        $this->model = ConversionQueue::find()->where(['id' => $this->idQueue])
            ->andWhere(['IN', 'status_id', [ConversionStatusQueue::STATUS_NEW]])->one();
        if ($this->model === null) {
            return true;
        }
        $this->setStatus(ConversionStatusQueue::STATUS_SENDING);
        $this->model->pixels = $this->model->getIdsPixels();
        return $this->sendConversionData($this->model);
    }

    /**
     * @param ConversionQueue $model
     * @return bool
     */
    public function sendConversionData(ConversionQueue $model) : bool
    {
        try {
            if (FacebookConversionSender::send($model)) {
                $this->setStatus(ConversionStatusQueue::STATUS_DONE);
                return true;
            } else {
                $this->setStatus(ConversionStatusQueue::STATUS_ERROR);
                \Yii::warning('Not found data for queue with ID: ' . $model->id);
                return false;
            }
        } catch (\Exception $e) {
            $this->setStatus(ConversionStatusQueue::STATUS_ERROR);
            \Yii::warning($e->getMessage());
            return false;
        }
    }

    public function setStatus($status)
    {
        $this->model->status_id = $status;
        $this->model->save(false);
    }
}
