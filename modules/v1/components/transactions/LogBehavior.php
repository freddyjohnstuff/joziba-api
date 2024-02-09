<?php

namespace app\api\modules\v1\components\transactions;

use Yii;
use app\models\Users;
use yii\db\BaseActiveRecord;

/**
 * LogBehavior для моделей
 */
class LogBehavior extends \yii\base\Behavior
{

    /**
     * user
     *
     * @var bool|Users
     */
    public $user = false;
    /**
     * logCategory
     *
     * @var string
     */
    public $logCategory;

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof \yii\console\Application) {
            return $this->user = null;
        }
        if ($this->user === false) {
            $this->user = Users::findOne(Yii::$app->user->id);
        } else {
            $this->user = \yii\di\Instance::ensure($this->user, Users::class);
        }
    }

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT =>  fn ($event) => $this->log($event->sender, 'create'),
            BaseActiveRecord::EVENT_AFTER_UPDATE =>  fn ($event) => $this->log($event->sender, 'update'),
            BaseActiveRecord::EVENT_AFTER_DELETE =>  fn ($event) => $this->log($event->sender, 'delete'),
            BaseActiveRecord::EVENT_AFTER_FIND => fn ($event) => $this->log($event->sender, 'view'),
        ];
    }

    public function log($model, string $userAction)
    {
        Yii::info(
            json_encode([
                'user' => $this->user->username ?? 'no user set',
                'userAction' => $userAction,
                'model' => $model->toArray(),
            ]),
            $this->logCategory
        );
    }
}
