<?php

namespace app\modules\v1\components\controller;

use OpenApi\Annotations as OA;
use Yii;
use app\modules\v1\traits\ControllerActionsDefault;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * @OA\WInfo(
 *     title="Joziba backend api"
 *     version="1.0",
 * )
 */
/**
 * @OA\OpenApi(
 *    security={{"bearerAuth": {}}}
 * )
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *     )
 * )
 */
class BaseActiveController extends ActiveController
{
    use ControllerActionsDefault;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Total-Count',
                    'X-Pagination-Per-Page'
                ],
            ]
        ];
        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    protected function getUserIdFromModel($model = null, $param = 'user_id')
    {
        $id = \Yii::$app->request->get('id');
        if ($model) {
            $model::findOne($id);
        } else {
            $model = $this->modelClass::findOne($id);
        }
        $userId = $model->$param ?? null;
        return ['userId' => $userId];
    }
}
