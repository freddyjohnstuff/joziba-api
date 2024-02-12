<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsStatus;
use app\models\HelperType;
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
 * HelperTypeController implements the CRUD actions for HelperType model.
 */
/**
 * @OA\Tag(name="helper-type",description="CRUD actions for helper-type"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/helper-type",
 *     tags={"helper-type"},
 *     summary="Get helper-type",
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
 *                     name="fld_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_parameters",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="fld_key,fld_name", summary="fld_key ASC,fld_name ASC"),
 *                       @OA\Examples(example="sorting2", value="-fld_key,-fld_name", summary="fld_key DESC,fld_name DESC"),
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
 *     path="/api/v1/helper-type",
 *     tags={"helper-type"},
 *     summary="Adds a new helper-type",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Parameter(
 *                     name="fld_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_parameters",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "fld_key": "volume",
 *                   "fld_name": "Volume",
 *                   "fld_parameters": "0"
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
 *     path="/api/v1/helper-type/{id}",
 *     tags={"helper-type"},
 *     summary="Edit helper-type",
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
 *                     name="fld_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_parameters",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "fld_name": "New helper name",
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
 *     path="/api/v1/helper-type/{id}",
 *     tags={"helper-type"},
 *     summary="Update fields helper-type",
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
 *                     name="fld_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="fld_parameters",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 example={
 *                   "fld_name": "New helper name",
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
 *     path="/api/v1/helper-type/{id}",
 *     tags={"helper-type"},
 *     summary="Delete helper-type",
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
class HelperTypeController extends ActiveController
{
    public $modelClass = HelperType::class;

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
