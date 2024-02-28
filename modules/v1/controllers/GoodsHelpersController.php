<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsStatus;
use app\models\GoodsHelpers;
use app\models\search\GoodsHelpersSearch;
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
 * GoodsHelpersController implements the CRUD actions for Goods Helpers model.
 */
/**
 * @OA\Tag(name="goods-helpers",description="CRUD actions for goods-helpers"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/goods-helpers",
 *     tags={"goods-helpers"},
 *     summary="Get goods-helpers",
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
 *                 @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_label",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_default",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="fld_name,fld_label", summary="fld_name ASC,fld_label ASC"),
 *                       @OA\Examples(example="sorting2", value="-fld_name,-fld_label", summary="fld_name DESC,fld_label DESC"),
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
 *     path="/api/v1/goods-helpers",
 *     tags={"goods-helpers"},
 *     summary="Adds a new goods-helpers",
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
 *                 @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_label",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_default",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "category_id": 1,
 *                   "type_id": 1,
 *                   "fld_name": "volume",
 *                   "fld_label": "Volume",
 *                   "fld_default": null
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
 *     path="/api/v1/goods-helpers/{id}",
 *     tags={"goods-helpers"},
 *     summary="Edit goods-helpers",
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
 *                 @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_label",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_default",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "fld_name": "volume",
 *                   "fld_label": "Volume",
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
 *     path="/api/v1/goods-helpers/{id}",
 *     tags={"goods-helpers"},
 *     summary="Update fields goods-helpers",
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
 *                 @OA\Parameter(
 *                     name="type_id",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_label",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_default",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "fld_name": "volume",
 *                   "fld_label": "Volume",
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
 *     path="/api/v1/goods-helpers/{id}",
 *     tags={"goods-helpers"},
 *     summary="Delete goods-helpers",
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
class GoodsHelpersController extends BaseActiveController
{
    public $modelClass = GoodsHelpers::class;

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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){

        $searchModel = new GoodsHelpersSearch();
        $params = \Yii::$app->request->queryParams;
        $data = $searchModel->search($params);

        $models = $data->getModels();

        /** @var GoodsHelpers $model */
        foreach ($models as $model) {
            if($model->fld_parameters != null) {
                $model->fld_parameters = json_decode($model->fld_parameters);
            }
        }
        return ['models' => $models, 'count' => $data->getTotalCount()];
    }


    /**
     * @param $parentId
     * @return array|null
     */
    private function getHelper($parentId) {
        $allCategory = GoodsHelpers::find()->where(['parent_id' => $parentId])->all();
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
