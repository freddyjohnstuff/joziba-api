<?php

namespace app\modules\v1\controllers;

use app\lib\tools\media\MediaClass;
use app\models\Ads;
use app\models\AdsStatus;
use app\models\GoodsCategory;
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
 * GoodsCategoryController implements the CRUD actions for Good Category model.
 */
/**
 * @OA\Tag(name="goods-category",description="CRUD actions for Goods-category"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/goods-category",
 *     tags={"goods-category"},
 *     summary="Get goods-category",
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *         description="goods-category id",
 *         in="query",
 *         name="id",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="int", value="1", summary="An int value."),
 *     ),
 *                  @OA\Parameter(
 *                     name="parent_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_label",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_order",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="fld_key,fld_label", summary="fld_key ASC, fld_label ASC"),
 *                       @OA\Examples(example="sorting2", value="-fld_key,-fld_label", summary="fld_key DESC, fld_label DESC"),
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
 *     path="/api/v1/goods-category",
 *     tags={"goods-category"},
 *     summary="Adds a new goods-category",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="parent_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_label",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_order",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "parent_id": 0,
 *                   "fld_key": "cars",
 *                   "fld_label": "Cars and trucks",
 *                   "fld_order": "1"
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
 *     path="/api/v1/goods-category/{id}",
 *     tags={"goods-category"},
 *     summary="Edit goods-category",
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
 *                 @OA\Property(
 *                     property="parent_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_label",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_order",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "fld_label": "Cars and trucks",
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
 *     path="/api/v1/goods-category/{id}",
 *     tags={"goods-category"},
 *     summary="Update fields goods-category",
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
 *                 @OA\Property(
 *                     property="parent_id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_label",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="fld_order",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "fld_label": "Cars and trucks",
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
 *     path="/api/v1/goods-category/{id}",
 *     tags={"goods-category"},
 *     summary="Delete goods-category",
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
class GoodsCategoryController extends BaseActiveController
{
    public $modelClass = GoodsCategory::class;

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
        $action = parent::actions();
        unset($action['index']);
        return $action;
    }


    /**
     * @return array|\yii\data\ActiveDataProvider|null
     */
    public function actionIndex()
    {
        return $this->getCategory(0);
    }


    /**
     * @param $parentId
     * @return array|null
     */
    private function getCategory($parentId) {
        $allCategory = GoodsCategory::find()->where(['parent_id' => $parentId])->all();
        if(!$allCategory) {
            return null;
        }

        $result = [];
        foreach ($allCategory  as $category) {
            $_cur = $category->toArray();
            if($_cur['parent_id'] == 0) {
                $_cur['parent_id'] = null;
            }
            $_cur['children'] = $this->getCategory($category->id);
            $_cur['media'] = MediaClass::getInstance()->getMediaList($category->id, 'category');

            $result[] = $_cur;
        }
        return $result;
    }

}
