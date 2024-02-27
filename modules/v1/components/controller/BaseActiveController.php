<?php

namespace app\modules\v1\components\controller;

use OpenApi\Annotations as OA;
use Yii;
use app\modules\v1\traits\ControllerActionsDefault;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\rest\ActiveController;

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
class BaseActiveController extends ActiveController
{
    use ControllerActionsDefault;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['basicAuth'] = [
            'class' => HttpBearerAuth::class,
            /*'pattern' =>'/^(.*?)$/'*/
            'except' => ['index', 'view']
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Headers' => ['origin', 'X-Requested-With', 'Accept', 'authorization'],
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


    public function beforeAction($action)
    {

        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Credentials: true ");
        header("Access-Control-Allow-Methods: " . implode(',', ['','GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS']));

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Headers: " . implode(',', ['Origin', 'X-Requested-With', 'Accept', 'Authorization']));
            Yii::$app->end();
        }

        return parent::beforeAction($action);
    }



    public function checkIsPost() {


    }

    public function sendErrorCode($code = 200) {
        \Yii::$app->response->statusCode = $code;
    }
}
