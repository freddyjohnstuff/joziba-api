<?php

namespace app\modules\v1\controllers;

use app\models\ResetForm;
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


class ResetController extends BaseController
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
            return ['message' => 'Method not allowed!'];
        }

        $post = \Yii::$app->request->post();
        if(!isset($post['email'])) {
            \Yii::$app->response->statusCode = 400;
            return ['message' => 'Skipped some fields'];
        }


        $form = new ResetForm();
        if($form->load(['reset' => \Yii::$app->request->post()], 'reset') && $form->validate()){
            $reset = $form->reset();
            if ($reset) {
                \Yii::$app->response->statusCode = 200;
                return [
                    'message' => 'Message sent!' . var_export($reset)
                ];
            } else {
                \Yii::$app->response->statusCode = 400;
                return ['message' => 'Something went wrong, Try again!'];
            }
        } else {
            \Yii::$app->response->statusCode = 400;
            $_allError = [];
            $_errors = $form->getErrors();
            if(!empty($_errors)) {
                foreach ($_errors as $key => $_error) {
                    $_allError[$key] = $_error[0];
                }
            }
            return ['request' => $_allError];
        }

        \Yii::$app->end();

    }
}
