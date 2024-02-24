<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsSearch;
use app\modules\v1\components\controller\BaseActiveController;
use OpenApi\Annotations as OA;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

/**
 * @OA\\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Description removed for better illustration of structure.",
 * )
 */

/**
 * AdsController.php implements the Rest CRUD Ads.
 */
/**
 * @OA\Tag(name="ads",description="CRUD actions for Ads"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/ads",
 *     tags={"ads"},
 *     summary="Get ads",
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *         description="ads id",
 *         in="query",
 *         name="id",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="integer", value="1", summary="An int value."),
 *     ),
 *                  @OA\Parameter(
 *                     name="client_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="status_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="published",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                  @OA\Examples(example="true", value="1", summary="true"),
 *                  @OA\Examples(example="false", value="0", summary="false"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="title",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="description",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                @OA\Parameter(
 *                     name="expired_date",
 *                     in="query",
 *                     @OA\Schema(type="date"),
 *                 ),
 *                @OA\Parameter(
 *                     name="publish_date",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                @OA\Parameter(
 *                     name="expired_date",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="title,-publish_date", summary="title ASC,publish_date DESC"),
 *                       @OA\Examples(example="sorting2", value="-publish_date, title", summary="publish_date DESC,title ASC"),
 *                     @OA\Schema(type="string"),
 *                 ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/v1/ads",
 *     tags={"ads"},
 *     summary="Adds a new Ad",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="published",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="expired_date",
 *                     type="date"
 *                 ),
 *                 @OA\Property(
 *                     property="publish_date",
 *                     type="date"
 *                 ),

 *                 example={
 *                   "published": 0,
 *                   "title": "Ad title",
 *                   "description": "Ad description",
 *                   "expired_date": "+1M",
 *                   "publish_date": "2024-02-10"
 *                  }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/api/v1/ads/{id}",
 *     tags={"ads"},
 *     summary="Edit ad",
 *     security={{ "bearerAuth":{} }},
 *      @OA\Parameter(
 *                     name="id",
 *                     in="path",
 *                     description="id",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="status_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="published",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="expired_date",
 *                     type="date"
 *                 ),
 *                 @OA\Property(
 *                     property="publish_date",
 *                     type="date"
 *                 ),
 *                 example={
 *                   "title": "New ad title",
 *                  }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

/**
 * @OA\Patch(
 *     path="/api/v1/ads/{id}",
 *     tags={"ads"},
 *     summary="Update fields ad",
 *     security={{ "bearerAuth":{} }},
 *      @OA\Parameter(
 *                     name="id",
 *                     in="path",
 *                     description="id",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="status_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="published",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="expired_date",
 *                     type="date"
 *                 ),
 *                 @OA\Property(
 *                     property="publish_date",
 *                     type="date"
 *                 ),
 *                 example={
 *                   "title": "New ad title",
 *                  }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/v1/ads/{id}",
 *     tags={"ads"},
 *     summary="Delete ad",
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="id",
 *          @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(response=200,description="OK"),
 *     @OA\Response(response=401,description="Unauthorized"),
 *     @OA\Response(response=404,description="Not Found")
 * )
 */
class MyAdsController extends BaseActiveController
{
    public $modelClass = Ads::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete', 'view', 'index', 'options'],
                    /*'roles' => [],*/
                ],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $searchModel = new AdsSearch();
        $params = \Yii::$app->request->queryParams;
        /*if (!\Yii::$app->user->can(Permissions::VIEW_LIST_COMPANY)) {
            $params['user_id'] = \Yii::$app->user->getId();
        }*/
        $data = $searchModel->search($params);
        return ['models' => $data->getModels(), 'count' => $data->getTotalCount()];
    }


}
