<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GoodsHelpers;

/**
 * GoodsHelpersSearch represents the model behind the search form of `app\models\GoodsHelpers`.
 */
class GoodsHelpersSearch extends GoodsHelpers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'type_id'], 'integer'],
            [['fld_name', 'fld_label', 'fld_default', 'fld_parameters'], 'safe'],
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
        $query = GoodsHelpers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['in','id',$this->id]);
        $query->andFilterWhere(['in','category_id',$this->category_id]);
        $query->andFilterWhere(['in','type_id',$this->id]);

        $query->andFilterWhere(['like', 'fld_name', $this->fld_name]);
        $query->andFilterWhere(['like', 'fld_label', $this->fld_label]);
        $query->andFilterWhere(['like', 'fld_default', $this->fld_default]);
        $query->andFilterWhere(['like', 'fld_parameters', $this->fld_parameters]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
            'attributes' => [
                'fld_name',
                'id',
            ],
        ]);

        return $dataProvider;
    }
}
