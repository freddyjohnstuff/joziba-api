<?php
namespace app\api\modules\v1\components\postback;

use app\models\CpaDeposits;
use app\models\CpaPostbacks;
use app\models\CpaRegistrations;
use app\models\Events;
use app\models\PartnersPayouts;
use app\models\Postback;
use Yii;
use yii\base\Exception;

class PostbackHandler
{
    protected Postback $model;
    protected $error;

    /**
     * PostbackHandler constructor.
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->model = new Postback();
        $this->model->load($data, '');
        if (!$this->model->validate()) {
            throw new Exception('Error validate postback data: '. serialize($this->model->errors));
        }
        $this->model->payout = $this->getPayout();
    }

    /**
     * @return bool
     */
    public function addPostback() : bool
    {
        try {
            $event = $this->addEvent();
            $this->addCpaPostback($event->id);
            if ((float)$this->model->payout > 0) {
                $this->setPostbackDeposit($event->id);
            } else {
                $this->setPostbackRegistration($event->id);
            }
            return true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Yii::error($message);
            $this->setError($message);
            return false;
        }
    }


    /**
     * @param array $data
     * @return Events
     * @throws Exception
     */
    protected function addEvent()
    {
        $event = new Events();
        if ($event->load($this->model->getAttributes(), '')) {
            $event->binom_click_id = $this->model->click_id;
            $event->type = CpaPostbacks::getType();
            if ($event->save()) {
                return $event;
            } else {
                throw new Exception('Error by save data to events model' . serialize($event->errors));
            }
        } else {
            throw new Exception('Error by load data to events model');
        }
    }

    /**
     * @param $eventId
     * @return CpaPostbacks
     * @throws Exception
     */
    protected function addCpaPostback($eventId)
    {
        $postback = new CpaPostbacks();
        $postback->load($this->model->getAttributes(), '');
        $postback->event_id = $eventId;
        $postback->payout_usd = (float) $this->model->payout;
        $postback->status = $this->model->cnv_status;
        
        if ($postback->save()) {
            return $postback;
        } else {
            throw new Exception('Error by save postback'.serialize($postback->errors));
        }
    }

    /**
     * @param $postbackId
     */
    protected function setPostbackRegistration($postbackId)
    {
        $registration = CpaRegistrations::find()
            ->joinWith('event')
            ->where(['=', 'events.binom_click_id', $this->model->click_id])
            ->andWhere(['=', 'type', CpaRegistrations::getType()])
            ->one();
        if ($registration) {
            $registration->postback_event_id = $postbackId;
            $registration->save();
        }
    }

    /**
     * @param $postbackId
     * @return CpaDeposits|array|\yii\db\ActiveRecord|null
     * @throws Exception
     */
    protected function setPostbackDeposit($postbackId)
    {
        $dep = CpaDeposits::find()
            ->joinWith('event')
            ->where(['=', 'events.binom_click_id', $this->model->click_id])
            ->andWhere(['=', 'type', CpaDeposits::getType()])
            ->one();
        if ($dep === null) {
            $dep = new CpaDeposits();
            $dep->event_id = $postbackId;
        }
        $dep->postback_event_id = $postbackId;
        $dep->payout_usd = $this->model->payout;
        if ($dep->save()) {
            return $dep;
        } else {
            throw new Exception('Error by save deposits: '.serialize($dep->errors));
        }
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function getPayout()
    {
        if ($this->model->payout !== null) {
            return $this->model->payout;
        }
        if ($this->model->partner_id !== null) {
            $partnerPayout = PartnersPayouts::findOne([
                'partner_id' => $this->model->partner_id,
                'country_code' => $this->model->country
            ]);
            if ($partnerPayout === null) {
                throw new Exception('Not found payout for partner_id: '. $this->model->partner_id);
            }
            return $partnerPayout->payout_usd;
        } else {
            throw new Exception('Not found parameters payout or partner_id');
        }
    }

    protected function setError($error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }
}
