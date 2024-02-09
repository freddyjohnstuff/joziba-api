<?php

namespace app\modules\v1\controllers;

use app\models\Ads;
use app\models\AdsStatus;
use app\models\Profile;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

/**
 * CampaignsController implements the CRUD actions for Partners model.
 */
/**
 * @OA\Tag(name="partners",description="CRUD actions for Partners"),
 */
/**
 * @OA\Get(
 *     path="/api/v1/partners",
 *     tags={"partners"},
 *     summary="Get partners",
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
 *                     name="name",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="partner_key",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                 @OA\Parameter(
 *                     name="type",
 *                     in="query",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                  @OA\Parameter(
 *                     name="site",
 *                     in="query",
 *                     description="internet site",
 *                     @OA\Schema(type="string"),
 *                 ),
 *                @OA\Parameter(
 *                     name="status",
 *                     in="query",
 *                     @OA\Schema(type="integer"),
 *                  @OA\Examples(example="true", value="1", summary="true"),
 *                  @OA\Examples(example="false", value="0", summary="false"),
 *                 ),
 *                   @OA\Parameter(
 *                     name="sort",
 *                     in="query",
 *                     description="sort",
 *                       @OA\Examples(example="sorting1", value="-name,id", summary="name DESC,id ASC"),
 *                       @OA\Examples(example="sorting2", value="-id, name", summary="id DESC,name ASC"),
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
 *     path="/api/v1/partners",
 *     tags={"partners"},
 *     summary="Adds a new partners",
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="partner_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="boolean"
 *                 ),
 *                 @OA\Property(
 *                     property="type",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="company_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="address",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="postcode",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="country",
 *                     description="id страны из справочника стран",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="city",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="site",
 *                     description="internet site",
 *                     type="string",
 *                 ),
 *                  @OA\Property(
 *                     property="tax_number",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "name": "Partner name",
 *                   "partner_key": "PartnerKey",
 *                   "status": "1",
 *                   "type": "buying",
 *                   "company_name": "P1 Company Name",
 *                   "address": "Petrova st.",
 *                   "postcode": "666666",
 *                   "country": "11",
 *                   "city": "Praha",
 *                   "site": "http://p1site.com",
 *                   "tax_number": "666999888555222",
 *
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
 *     path="/api/v1/partners/{id}",
 *     tags={"partners"},
 *     summary="Edit partners",
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
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="partner_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="boolean"
 *                 ),
 *                 @OA\Property(
 *                     property="type",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="company_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="address",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="postcode",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="country",
 *                     description="id страны из справочника стран",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="city",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="site",
 *                     description="internet site",
 *                     type="string",
 *                 ),
 *                  @OA\Property(
 *                     property="tax_number",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "name": "New name partner",
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
 *     path="/api/v1/partners/{id}",
 *     tags={"partners"},
 *     summary="Update fields partners",
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
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="partner_key",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="boolean"
 *                 ),
 *                 @OA\Property(
 *                     property="type",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="company_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="address",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="postcode",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="country",
 *                     description="id страны из справочника стран",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="city",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="site",
 *                     description="internet site",
 *                     type="string",
 *                 ),
 *                  @OA\Property(
 *                     property="tax_number",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "name": "New name partner",
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
 *     path="/api/v1/partners/{id}",
 *     tags={"partners"},
 *     summary="Delete partners",
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
class ProfileController extends ActiveController
{
    public $modelClass = Profile::class;

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
