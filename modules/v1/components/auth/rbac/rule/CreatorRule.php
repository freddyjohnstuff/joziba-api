<?php
namespace app\modules\v1\components\auth\rbac\rule;

use yii\rbac\Rule;

class CreatorRule extends Rule
{
    public $name = 'isCreator';

    public function execute($user, $item, $params)
    {
        return isset($params['userId']) && $params['userId'] == $user;
    }
}