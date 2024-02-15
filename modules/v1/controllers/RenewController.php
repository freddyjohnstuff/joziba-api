<?php

namespace app\modules\v1\controllers;

use app\models\ClientTokenHolder;
use app\models\SingInForm;
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
            return $this->returnWithError('Method not allowed');
        }

        $post = \Yii::$app->request->post();
        if(!isset($post['refresh_token'])) {
            return $this->returnWithError('Some field sending incorrect');
        }

        $form = new SingInForm();
        $clientToken = $form->renewAccessToken($post['refresh_token']);
        if(!$clientToken){
            return $this->returnWithError('Refresh token expired');
        }

        return $this->returnSuccess([
            'tokens' => $clientToken
        ]);
    }

}
