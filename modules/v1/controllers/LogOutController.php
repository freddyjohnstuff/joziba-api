<?php

namespace app\modules\v1\controllers;

use app\models\SingInForm;
use app\models\SingUpForm;
use app\modules\v1\components\controller\BaseActiveController;
use app\modules\v1\components\controller\BaseController;
use OpenApi\Annotations as OA;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class LogOutController extends BaseController
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
            \Yii::$app->end();
        }

        $post = \Yii::$app->request->post();
        if(!isset($post['access_token'])) {
            return $this->returnWithError('Some field sending incorrect');
            \Yii::$app->end();
        }

        $form = new SingInForm();

        if($form->logout($post['access_token'])) {
            return $this->returnSuccess([
                'message' => 'Log Out successfully!'
            ]);
        } else {
            return $this->returnWithError(
                'Something went wrong!');
        }
    }

}
