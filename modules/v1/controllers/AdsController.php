<?php

namespace app\modules\v1\controllers;

use app\lib\tools\clients\ClientTools;
use app\lib\tools\media\MediaClass;
use app\models\Ads;
use app\models\GoodsHelpers;
use app\models\GoodsHelpersValue;
use app\models\search\AdsSearch;
use app\models\ServiceGoods;
use app\modules\v1\components\controller\BaseActiveController;
use OpenApi\Annotations as OA;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\MultipartFormDataParser;
use yii\web\NotFoundHttpException;
use function PHPUnit\Framework\returnArgument;

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
class AdsController extends BaseActiveController
{
    const SERVICE_GOODS_TYPE = 1;

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
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $searchModel = new AdsSearch();
        $params = \Yii::$app->request->queryParams;
        unset($params['client_id']);
        if (!empty($params) && array_key_exists('private-view', $params)) {

            $client_id = ClientTools::getInstance()->getCurrentClientId();
            if(!$client_id) {
                $this->sendErrorCode(400);
                return ['message' => 'Unauthorised access'];
            }
            $params['client_id'] = $client_id;
        }
        $data = $searchModel->search($params);
        $models = $data->getModels();
        $newModels = [];
        if (!empty($models)) {
            foreach ($models as $model) {


                $hasHelper = false;
                $allowedHelper = false;
                if (isset($params['helpers'])) {
                    $hasHelper = true;

                    if (!empty($model->serviceGoods)) {
                        $helpers = GoodsHelpers::find()->where(['category_id' => $model->serviceGoods[0]->category_id]);
                    } else {
                        $helpers = GoodsHelpers::find();
                    }

                    $helpers = $helpers->all();
                    if ($helpers) {
                        /** @var GoodsHelpers $helper */
                        foreach ($helpers as $helper) {
                            if(isset($params['helpers'][$helper->fld_name]))
                            {
                                $value = GoodsHelpersValue::find()
                                    ->where(
                                        [
                                            'AND',
                                            ['service_goods_id' => $model->serviceGoods[0]->id],
                                            ['helper_id' => $helper->id]
                                        ]
                                    )
                                    ->one();

                                if($value) {
                                    if($value->value == $params['helpers'][$helper->fld_name]) {
                                        $allowedHelper = true;
                                    }
                                }

                            }

                        }
                    }

                }

                if(!$hasHelper || ($hasHelper && $allowedHelper)) {
                    $_model = $model->toArray();
                    $_model['media'] = MediaClass::getInstance()->getMediaList($model->id, 'ads');
                    $_model['category'] = (!empty($model->serviceGoods)) ? $model->serviceGoods[0]->category : null;
                    $_model['helpers'] = (!empty($model->serviceGoods)) ? $model->serviceGoods[0]->getGoodsHelpersValuesWithLabels() : null;
                    $_model['city'] = (!empty($model->city)) ? $model->city->toArray() : null;
                    $newModels[] = $_model;
                }
            }
        }
        return ['models' => $newModels, 'count' => $data->getTotalCount(), 'pages' => $data->pagination->links];
    }

    public function actionView($id)
    {
        $model = Ads::find()
                ->where(Ads::tableName() . '.status_id!=6')
                ->andWhere(['id' => $id])
                ->one();
        if(!$model)
        {
            $this->sendErrorCode(400);
            return ['message' => 'Entity not found'];
        }
        $_model = $model->toArray();
        $_model['media'] = MediaClass::getInstance()->getMediaList($model->id, 'ads');
        $_model['category'] = (!empty($model->serviceGoods)) ? $model->serviceGoods[0]->category : null;
        $_model['helpers'] = (!empty($model->serviceGoods)) ? $model->serviceGoods[0]->getGoodsHelpersValuesWithLabels() : null;
        $_model['city'] = (!empty($model->city)) ? $model->city->toArray() : null;

        return $_model;
    }

    public function actionCreate()
    {

        $this->checkIsPost();
        $client_id = ClientTools::getInstance()->getCurrentClientId();
        $postData = \Yii::$app->request->post();

        if (!(
            isset($postData['city_id']) &&
            isset($postData['category_id']) &&
            isset($postData['title']) &&
            isset($postData['description']) &&
            isset($postData['expired'])
        )) {
            $this->sendErrorCode(400);
            return [
                'message' => 'You skipped some fields'
            ];
        }

        $createdDate = new \DateTime();
        $expiredAfter = (isset($postData['expired'])) ? $postData['expired'] : 4;
        $_tmpDate = new \DateTime($createdDate->format("Y-m-d H:i:s"));
        $expiredDate = $_tmpDate->add(new \DateInterval(sprintf("P%dW", $expiredAfter)));


        $ads = new Ads();
        $ads->load(
            [
                'ads' => [
                    'client_id' => $client_id,
                    'status_id' => 1 /* Embriyo */,
                    'city_id' => $postData['city_id'],
                    'title' => $postData['title'],
                    'description' => $postData['description'],
                    'expired_date' => $expiredDate->format("Y-m-d H:i:s"),
                    'publish_date' => $createdDate->format("Y-m-d H:i:s"),
                ]
            ],
            'ads'
        );
        if (!($ads->validate() && $ads->save())) {
            $this->sendErrorCode(400);
            return [
                'message' => 'Something went wrong',
                'errors' => $ads->getErrors()
            ];
        }

        $serviceGoods = new ServiceGoods();
        $serviceGoods->category_id = intval($postData['category_id']);
        $serviceGoods->type_id = self::SERVICE_GOODS_TYPE;
        $serviceGoods->ads_id = $ads->id;

        if (!($serviceGoods->validate() && $serviceGoods->save())) {
            $this->sendErrorCode(400);
            return [
                'message' => 'Something went wrong',
                'errors' => $serviceGoods->getErrors()
            ];
        }

        $helpersCreated = 0;
        if (!empty($postData['helpers'])) {

            $helpers = GoodsHelpers::find()
                ->where(['category_id' => intval($postData['category_id'])])
                ->all();

            if ($helpers) {
                foreach ($helpers as $helper) {
                    if (isset($postData['helpers'][$helper->fld_name])) {

                        $goodsHelpersValue = new GoodsHelpersValue();
                        $goodsHelpersValue->service_goods_id = $serviceGoods->id;
                        $goodsHelpersValue->helper_id = $helper->id;
                        $goodsHelpersValue->value = $postData['helpers'][$helper->fld_name];
                        if ($goodsHelpersValue->validate() && $goodsHelpersValue->save()) {
                            $helpersCreated++;
                        }
                    }
                }
            }
        }

        if (isset($_FILES['images'])) {
            $uploadedImages = MediaClass::getInstance()->createMediaList($ads->id);
        }
        return [
            'message' => 'Ads created',
            'ads' => $ads->id,
            'serviceGoods' => $serviceGoods->id,
            'helperCreated' => $helpersCreated,
            'uploadedMedia' => $uploadedImages ?? 0,
        ];

    }

    public function actionUpdate($id)
    {

        $header = \Yii::$app->request->headers->toArray();
        $body = file_get_contents('php://input');
        $parser = new MultipartFormDataParser();
        $postData = $parser->parse($body, $header['content-type'][0] ?? '');

        /*$this->checkIsPost();*/
        $client_id = ClientTools::getInstance()->getCurrentClientId();
        $fields = [
            'category_id',
            'city_id',
            'title',
            'description',
            'expired_date',
            'helpers',
            'images',
        ];

        $paramsCount = 0;
        foreach ($fields as $field) {
            if (isset($postData[$field])) {
                $paramsCount++;
            }
        }

        if ($paramsCount == 0) {
            $this->sendErrorCode(400);
            return ['message' => 'At least one parameter should be sent'];
        }

        /* @var $model Ads */
        $model = Ads::findOne($id);
        if (!$model) {
            $this->sendErrorCode(400);
            return ['message' => 'Entity not found'];
        }

        if ($model->client_id != $client_id) {
            $this->sendErrorCode(400);
            return ['message' => 'Unauthorised access'];
        }

        if (isset($postData['expired_date'])) {
            $updatedDate = new \DateTime($postData['expired_date']);
            $model->expired_date = $updatedDate->format('Y-m-d H:i:s');
        }

        if (isset($postData['title'])) {
            $model->title = $postData['title'];
        }
        if (isset($postData['description'])) {
            $model->description = $postData['description'];
        }

        if (isset($postData['city_id'])) {
            $model->city_id = $postData['city_id'];
        }

        if (isset($postData['category_id'])) {
            $serviceGoods = ServiceGoods::findOne($model->serviceGoods[0]->id);
            $serviceGoods->category_id = $postData['category_id'];
            $serviceGoodsSaved = $serviceGoods->validate() && $serviceGoods->save();
        }

        if (isset($_FILES['images'])) {
            $uploadedImages = MediaClass::getInstance()->createMediaList($model->id);
        }

        $updatedSystemDate = new \DateTime();
        $model->updated_at = $updatedSystemDate->format('Y-m-d H:i:s');

        $helpersCreated = 0;
        if (!empty($postData['helpers'])) {

            $helpers = GoodsHelpers::find()
                ->where(['category_id' => intval($postData['category_id'])])
                ->all();

            if ($helpers) {
                foreach ($helpers as $helper) {
                    if (isset($postData['helpers'][$helper->fld_name])) {

                        $existHlpr = GoodsHelpersValue::find()
                            ->where([
                                'AND',
                                ['service_goods_id' => $model->serviceGoods[0]->id],
                                ['helper_id' => $helper->id]
                            ])
                            ->one();
                        if ($existHlpr) {
                            $existHlpr->value = $postData['helpers'][$helper->fld_name];
                            if ($existHlpr->validate() && $existHlpr->save()) {
                                $helpersCreated++;
                            }
                        } else {
                            $goodsHelpersValue = new GoodsHelpersValue();
                            $goodsHelpersValue->service_goods_id = $model->serviceGoods[0]->id;
                            $goodsHelpersValue->helper_id = $helper->id;
                            $goodsHelpersValue->value = $postData['helpers'][$helper->fld_name];
                            if ($goodsHelpersValue->validate() && $goodsHelpersValue->save()) {
                                $helpersCreated++;
                            }
                        }
                    }
                }
            }
        }


        return [
            'message' => 'Ads updated',
            'ads' => $model->id,
            'serviceGoods' => $model->serviceGoods[0]->id,
            'helperCreated' => $helpersCreated,
            'uploadedMedia' => $uploadedImages ?? 0,
            'categoryUpdated' => $serviceGoodsSaved ?? 0,
        ];
    }


    public function actionDelete($id)
    {
        $ads = Ads::findOne($id);
        if(!$ads) {
            $this->sendErrorCode(400);
            return ['message' => 'Entity not found'];
        }

        $client_id = ClientTools::getInstance()->getCurrentClientId();
        if($ads->client_id != $client_id) {
            $this->sendErrorCode(400);
            return ['message' => 'Unauthorised access'];
        }

        $ads->status_id = 6;
        if(!$ads->save()) {
            $this->sendErrorCode(400);
            return [
                'message' => 'Something went wrong',
                'errors' => $ads->getErrors(),
            ];
        }
        return ['message' => 'Ads removed successful!'];
    }
}
