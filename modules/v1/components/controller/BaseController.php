<?php

namespace app\modules\v1\components\controller;

use OpenApi\Annotations as OA;
use app\modules\v1\traits\ControllerActionsDefault;
use yii\filters\auth\HttpBearerAuth;
use yii\gii\CodeFile;
use yii\web\Controller;
use yii\web\Request;

/**
 * @OA\Info(
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
class BaseController extends \yii\rest\Controller
{
    use ControllerActionsDefault;
    public $enableCsrfValidation = false;
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Headers' => ['Origin', 'X-Requested-With', 'Accept', 'Authorization'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Total-Count',
                    'X-Pagination-Per-Page'
                ],
            ]
        ];
        return $behaviors;
    }
}
