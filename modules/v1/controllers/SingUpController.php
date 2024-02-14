<?php

namespace app\modules\v1\controllers;

use app\models\SingUpForm;
use app\modules\v1\components\controller\BaseActiveController;
use app\modules\v1\components\controller\BaseController;
use OpenApi\Annotations as OA;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SingUpController extends BaseController
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
        if(
            !(
                isset($post['email']) &&
                isset($post['phone']) &&
                isset($post['password1']) &&
                isset($post['password2'])
            )
        ) {
            return $this->returnWithError('Some field sending incorrect');
        }


        $form = new SingUpForm();
        if($form->load(['sing-up' => \Yii::$app->request->post()], 'sing-up') && $form->validate()){

            $saved = $form->singup();
            if ($saved) {
                return $this->returnSuccess([
                    'message' => 'Client created'
                ]);
            } else {
                return $this->returnWithError('Something went wrong, Try again!', 500);
            }
        } else {
            $_allError = [];
            $_errors = $form->getErrors();
            if(!empty($_errors)) {
                foreach ($_errors as $_error) {
                    $_allError[] = $_error[0];
                }
            }
            return $this->returnWithError(implode(',', $_allError));
        }
    }


}
