<?php

namespace app\modules\v1\controllers;

use app\models\ClientTokenHolder;
use app\models\SignInForm;
use app\models\SingUpForm;
use app\modules\v1\components\controller\BaseActiveController;
use app\modules\v1\components\controller\BaseController;
use OpenApi\Annotations as OA;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * @OA\\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Description removed for better illustration of structure.",
 * )
 */

/**
 * @OA\Tag(name="renew",description="Renew actions"),
 */

class RenewController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    /*'roles' => [],*/
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['post'],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        return ['index'];
    }

    /**
     * @return array
     */
    public function actionIndex()
    {

        if(!\Yii::$app->request->isPost) {
            \Yii::$app->response->statusCode = 400;
            return ['message' => 'Method not allowed'];
        }

        $header = \Yii::$app->request->getHeaders()->toArray();

        if(array_key_exists('authorization', $header) === false) {
            \Yii::$app->response->statusCode = 401;
            return ['message'=>'Cannot get Renew Key!'];
        }

        $xRenewKey = $header['authorization'][array_keys($header['authorization'])[0]];
        if (preg_match('/^Bearer\s+(.*?)$/', $xRenewKey, $matches)) {
            $xRenewKey = $matches[1];
        }

        $form = new SignInForm();
        $clientToken = $form->renewAccessToken($xRenewKey);
        if(!$clientToken){
            \Yii::$app->response->statusCode = 400;
            return ['message' => 'Refresh token expired!'];
        }

        return [
            'access' => \Yii::$app->jwt->createJWTToken(['token' => $clientToken['access_token'], 'exp' => $clientToken['access_token_expired']]),
            'refresh' => \Yii::$app->jwt->createJWTToken(['token' => $clientToken['refresh_token'], 'exp' => $clientToken['refresh_token_expired']])
        ];

    }

}
