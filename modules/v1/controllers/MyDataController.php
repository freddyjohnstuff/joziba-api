<?php

namespace app\modules\v1\controllers;

use app\models\Clients;
use app\models\ClientTokenHolder;
use app\models\Profile;
use app\models\SignInForm;
use app\models\SingUpForm;
use app\modules\v1\components\controller\BaseActiveController;
use app\modules\v1\components\controller\BaseController;
use http\Client;
use OpenApi\Annotations as OA;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
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

class MyDataController extends BaseActiveController
{
    public $modelClass = Profile::class;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index','create', 'update','view', 'options'],
                    /*'roles' => [],*/
                ],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions =  parent::actions();
        return [];
    }


    /**
     * @return array
     */
    public function actionIndex()
    {

        if(!\Yii::$app->request->isGet) {
            return $this->returnWithError('Method not allowed');
        }

        $header = \Yii::$app->request->getHeaders()->toArray();

        if(array_key_exists('Authorization', $header) === false) {
            \Yii::$app->response->statusCode = 401;
            return ['message'=>'Cannot get Api Key!'];
        }


        $XApiKey = $header['Authorization'][array_keys($header['Authorization'])[0]];
        if (preg_match('/^Bearer\s+(.*?)$/', $XApiKey, $matches)) {
            $XApiKey = $matches[1];
        }
        $tokenHolder = ClientTokenHolder::find()
            ->where(['access_token' => $XApiKey])
            ->one();

        if(!$tokenHolder) {
            \Yii::$app->response->statusCode = 404;
            return ['message'=>'Profile not found!'];
        }

        $client = Clients::findOne($tokenHolder->client_id);

        if(!$client) {
            \Yii::$app->response->statusCode = 400;
            return ['message'=>'Client not found'];
        }

        $profileArray = $client->toArray();
        unset($profileArray['id']);
        unset($profileArray['reset_access_token']);
        unset($profileArray['remove_account_token']);


        $profiles =  $client->profiles;

        if(empty($profiles)) {
            \Yii::$app->response->statusCode = 400;
            return ['message'=>'Profile not created'];
        }
        $profile = $profiles[0]->toArray();

        return array_merge($profile, $profileArray);
    }


    public function actionCreate()
    {
        $phoneUpdated = 0;
        $nameUpdated = 0;

        if(!\Yii::$app->request->isPost) {
            return $this->returnWithError('Method not allowed');
        }

        $post = \Yii::$app->request->post();

        $header = \Yii::$app->request->getHeaders()->toArray();

        if(array_key_exists('Authorization', $header) === false) {
            \Yii::$app->response->statusCode = 401;
            return ['message'=>'Cannot get Api Key!'];
        }

        $XApiKey = $header['Authorization'][array_keys($header['Authorization'])[0]];
        $tokenHolder = ClientTokenHolder::find()
            ->where(['access_token' => $XApiKey])
            ->one();

        if(!$tokenHolder) {
            \Yii::$app->response->statusCode = 404;
            return ['message'=>'Profile not found!'];
        }

        $client = Clients::findOne($tokenHolder->client_id);

        if (isset($post['phone'])) {
            $phoneUpdated = Clients::updateAll(['phone' => $post['phone']], ['id' => $client->id]);
        }

        if(!$client) {
            \Yii::$app->response->statusCode = 400;
            return ['message'=>'Client not found'];
        }

        $profile = Profile::find()
            ->where(['client_id' => $client->id])
            ->one();

        if(isset($post['name'])) {
            $nameUpdated =  Profile::updateAll(['name' => $post['name']], ['id' => $profile->id]);
        }

        if(intval($phoneUpdated + $nameUpdated) > 0) {
            return ['message'=>'Updated data!'];
        } else {
            \Yii::$app->response->statusCode = 400;
            return ['message'=>'Something went wrong'];
        }
    }
}
