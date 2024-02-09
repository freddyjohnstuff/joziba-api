<?php

namespace app\api\modules\v1\traits;

use app\api\modules\v1\constants\Api;
use Yii;
use yii\data\ActiveDataProvider;

trait ControllerActionsDefault
{
    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function beforeAction($action)
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        Yii::$app->response->headers->set(
            'Access-Control-Allow-Headers',
            'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Set-Cookie'
        );
        Yii::$app->response->headers->set('Access-Control-Allow-Credentials', 'true');
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', Yii::$app->request->headers->get('origin'));

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }
    
    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider(
            [
                'query' => $this->modelClass::find(),
                'pagination' => [
                    'pageSize' => Api::PAGE_SIZE
                ],
            ]
        );
    }
}
