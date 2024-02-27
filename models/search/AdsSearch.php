<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ads;

/**
 * AdsSearch represents the model behind the search form of `app\models\Ads`.
 */
class AdsSearch extends Ads
{

    public $start_date;
    public $end_date;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'status_id', 'published'], 'integer'],
            [['title', 'description', 'expired_date', 'publish_date', 'created_at', 'updated_at', 'expired_at'], 'safe'],
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
        $query = Ads::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, 'filters');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'attributes' => [
                'title',
                'id',
                'publish_date',
                'client_id',
            ],
        ]);

        // grid filtering conditions
        $query
            ->andFilterWhere(['in', 'client_id', $this->client_id])
            ->andFilterWhere(['in', 'status_id', $this->status_id])
            ->andFilterWhere(['=', 'published', $this->published])
            ->andFilterWhere(['>=', 'publish_date', $this->start_date])
            ->andFilterWhere(['<=', 'publish_date', $this->end_date]);

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
