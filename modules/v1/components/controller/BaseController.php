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
/*    use ControllerActionsDefault;*/

    public $enableCsrfValidation = false;
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Accept', 'X-Api-Key'],
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

    public function returnWithError($message, $code = 400) {
        \Yii::$app->response->statusCode = $code;
        return [
            'message' => $message,
        ];
    }

    public function returnSuccess($scope, $code  = 200) {
        \Yii::$app->response->statusCode = $code;
        return [
            'code' => $code,
            'data' => $scope,
            'request' => $this->retrieveRequestBody(\Yii::$app->request)
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    private function retrieveRequestBody($request) {
        switch ($request->method) {
            case 'DELETE':
            case 'GET':
                return $request->get();
                break;
            case 'PUT':
            case 'UPDATE':
            case 'POST':
                return $request->post();
                break;
        }
        return null;
    }
}
