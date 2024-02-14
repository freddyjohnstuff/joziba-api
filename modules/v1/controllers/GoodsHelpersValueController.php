<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsStatus;
use app\models\GoodsHelpers;
use app\models\GoodsHelpersValue;
use app\modules\v1\components\controller\BaseActiveController;
use OpenApi\Annotations as OA;
use yii\debug\models\search\Base;
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
 * GoodsHelpersValueController implements the CRUD actions for GoodsHelpersValue model.
 */
/**
 * @OA\Tag(name="goods-helpers-value",description="CRUD actions for goods-helpers-value"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/goods-helpers-value",
 *     tags={"goods-helpers-value"},
 *     summary="Get goods-helpers-value",
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
 *                     name="service_goods_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="helper_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="value",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="-helper_id,id", summary="helper_id DESC,id ASC"),
 *                       @OA\Examples(example="sorting2", value="-id, helper_id", summary="id DESC,helper_id ASC"),
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
 *     path="/api/v1/goods-helpers-value",
 *     tags={"goods-helpers-value"},
 *     summary="Adds a new goods-helpers-value",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Parameter(
 *                     name="service_goods_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="helper_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="value",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "service_goods_id": 1,
 *                   "helper_id": 1,
 *                   "value": "24 m3"
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
 *     path="/api/v1/goods-helpers-value/{id}",
 *     tags={"goods-helpers-value"},
 *     summary="Edit goods-helpers-value",
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
 *                     name="service_goods_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="helper_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="value",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "value": "New value"
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
 *     path="/api/v1/goods-helpers-value/{id}",
 *     tags={"goods-helpers-value"},
 *     summary="Update fields goods-helpers-value",
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
 *                     name="service_goods_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="helper_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="value",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "value": "New value"
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
 *     path="/api/v1/goods-helpers-value/{id}",
 *     tags={"goods-helpers-value"},
 *     summary="Delete goods-helpers-value",
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
class GoodsHelpersValueController extends BaseActiveController
{
    public $modelClass = GoodsHelpersValue::class;

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
