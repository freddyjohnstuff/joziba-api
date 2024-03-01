<?php

namespace app\modules\v1\traits;

trait ControllerActionsDefault
{

    public function beforeAction($action)
    {
        header("Access-Control-Allow-Origin: * ");
        header("Access-Control-Allow-Credentials: true ");
        header("Access-Control-Allow-Methods: " . implode(',', ['','GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS']));

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Headers: " . implode(',', ['Origin', 'X-Requested-With', 'Accept', 'Authorization']));
            \Yii::$app->end();
        }

        \Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        \Yii::$app->response->headers->set(
            'Access-Control-Allow-Headers',
            'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Set-Cookie, Accept'
        );

        \Yii::$app->response->headers->set('Access-Control-Allow-Credentials', 'true');
        \Yii::$app->response->headers->set('Access-Control-Allow-Origin', \Yii::$app->request->headers->get('origin'));

        if (\Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            \Yii::$app->end();
        }
        return parent::beforeAction($action);
    }


    public function returnWithError($message, $code = 400) {
        \Yii::$app->response->statusCode = $code;
        return [
            'message' => $message,
        ];
    }

    public function returnSuccess($message, $code  = 200) {
        \Yii::$app->response->statusCode = $code;
        return [
            'message' => $message,
        ];
    }

    public function checkIsPost() {
        if (!\Yii::$app->request->isPost) {
            $this->sendErrorCode(405);
            return ['message' => 'Method Not Allowed'];
        }
    }

    public function sendErrorCode($code = 200) {
        \Yii::$app->response->statusCode = $code;
    }

}
