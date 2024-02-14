<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsStatus;
use app\models\ServiceGoods;
use app\modules\v1\components\controller\BaseActiveController;
use app\modules\v1\components\controller\BaseController;
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
 * ServiceGoodsController implements the CRUD actions for ServiceGoods model.
 */
/**
 * @OA\Tag(name="service-goods",description="CRUD actions for service-goods"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/service-goods",
 *     tags={"service-goods"},
 *     summary="Get service-goods",
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *         description="parametr id",
 *         in="query",
 *         name="id",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="int", value="1", summary="An int value."),
 *     ),
 *                  @OA\Parameter(
 *                     name="category_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="ads_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="-ads_id,id", summary="ads_id DESC,id ASC"),
 *                       @OA\Examples(example="sorting2", value="-id, ads_id", summary="id DESC,ads_id ASC"),
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
 *     path="/api/v1/service-goods",
 *     tags={"service-goods"},
 *     summary="Adds a new service-goods",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Parameter(
 *                     name="category_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="ads_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 example={
 *                   "category_id": 1,
 *                   "type_id": 1,
 *                   "ads_id": 1
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
 *     path="/api/v1/service-goods/{id}",
 *     tags={"service-goods"},
 *     summary="Edit service-goods",
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
 *                  @OA\Parameter(
 *                     name="category_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="ads_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 example={
 *                   "ads_id": 1,
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
 *     path="/api/v1/service-goods/{id}",
 *     tags={"service-goods"},
 *     summary="Update fields service-goods",
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
 *                  @OA\Parameter(
 *                     name="category_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="ads_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 example={
 *                   "ads_id": 1,
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
 *     path="/api/v1/service-goods/{id}",
 *     tags={"service-goods"},
 *     summary="Delete service-goods",
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
class ServiceGoodsController extends BaseActiveController
{
    public $modelClass = ServiceGoods::class;

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
}
