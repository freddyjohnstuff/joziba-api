<?php

namespace app\modules\v1\controllers;

use app\lib\tools\clients\ClientTools;
use app\models\Media;
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
 * @OA\Tag(name="log-out",description="logout actions"),
 */

class MediaController extends BaseController
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
            return ['message'=>'Cannot get Api Key!'];
        }

        $XApiKey = $header['authorization'][array_keys($header['authorization'])[0]];
        if (preg_match('/^Bearer\s+(.*?)$/', $XApiKey, $matches)) {
            $XApiKey = $matches[1];
        }

        $client = ClientTools::getInstance()->getClientByAccessToken($XApiKey);
        $client_id = ($client) ? $client->id : 0;


        $post = \Yii::$app->request->post();
        if (
            isset($post['target_entity']) &&
            isset($post['target_id']) &&
            isset($post['images'])
        ) {

            $imagesCNT = 0;
            $images = [];

            if (array_search($post['target_entity'], ['ads', 'category', 'client']) !== false) {
                $target = $post['target_entity'];
            } else {
                $target = 'others';
            }

            if (count($post['images']) > 0) {
                foreach ($post['images'] as $image) {

                    $media = new Media();
                    $media->target_entity = $target;
                    $media->target_id = $post['target_id'];
                    $name = md5($target . $post['target_id'] . date('Ymdhis') . time());

                    if (file_put_contents(\Yii::getAlias('@upload') . '/' . $name)) {
                        $media->media_path = \Yii::getAlias('@upload') . '/' . $name;
                        $media->media_url = 'http://api.joziba.online/uploads/' . $name;
                        $media->save();
                        $imagesCNT++;
                        $images[] = $media->media_url;
                    }
                }
            }

            if ($imagesCNT > 0) {
                return [
                    'message' => 'File(s) uploaded',
                    'images' => $images
                ];
            }
        }

        return ['message' => 'Something went wrong!'];

    }

}
