<?php

namespace app\models\search;

use app\models\ServiceGoods;
use app\modules\v1\constants\Api;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ads;

/**
 * AdsSearch represents the model behind the search form of `app\models\Ads`.
 */
class AdsSearch extends Ads
{

    public $category;
    public $start_date;
    public $end_date;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'status_id', 'published', 'city_id'], 'integer'],
            [['title', 'description', 'expired_date', 'publish_date', 'created_at', 'updated_at', 'expired_at', 'category'], 'safe'],
            [['start_date','end_date'], 'date', 'format' => 'php:Y-m-d H:i:s']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //todo: set a status = published in non private page
        $query = Ads::find()
            ->innerJoin(ServiceGoods::tableName(), self::tableName() . '.id = ' . ServiceGoods::tableName() . '.ads_id');
        //Removed ads
        $query->where(Ads::tableName() . '.status_id!=6');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => API::PAGE_SIZE_LIMIT,
                'defaultPageSize' => API::PAGE_SIZE
            ],
        ]);

        $this->load(['filters' => $params], 'filters');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'defaultOrder' => [
                Ads::tableName() . '.id' => SORT_DESC,
            ],
            'attributes' => [
                Ads::tableName().'.title',
                Ads::tableName().'.id',
                Ads::tableName().'.publish_date',
                Ads::tableName().'.client_id',
            ],
        ]);

        if(isset($params['client_id']) && !empty($params['client_id'])) {
            $query
                ->andFilterWhere(['in', Ads::tableName().'.client_id', $this->client_id])
                ->andFilterWhere(['in', Ads::tableName().'.status_id', [1,2,3,4,5]]);
        } else {
            $query->andFilterWhere(['in', Ads::tableName().'.status_id', [2]]);
        }

        // grid filtering conditions
        $query
            ->andFilterWhere(['=', Ads::tableName().'.city_id', $this->city_id])
            ->andFilterWhere(['=', Ads::tableName().'.published', $this->published])
            ->andFilterWhere(['>=', Ads::tableName().'.publish_date', $this->start_date])
            ->andFilterWhere(['<=', Ads::tableName().'.publish_date', $this->end_date]);

        $query->andFilterWhere([
            Ads::tableName().'.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', Ads::tableName().'.title', $this->title])
            ->andFilterWhere(['like', Ads::tableName().'.description', $this->description]);

        if (isset($params['category_id'])) {
            $query->andFilterWhere(['in', ServiceGoods::tableName() . '.category_id', $params['category_id']]);
        }

        return $dataProvider;
    }
}
