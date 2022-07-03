<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupItem;

/**
 * GroupSearch represents the model behind the search form of `app\models\Group`.
 */
class GroupItemSearch extends GroupItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','category_id','group_id','sequenced_number'], 'integer'],
            [['name'], 'safe'],
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
        $query = GroupItem::find();

        // add conditions that should always apply here
        $query->joinWith(['group','category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id
        ]);

        if(isset($this->name))
        {
            $query->andFilterWhere(['like', 'groups.name', $this->name]);
            $query->andFilterWhere(['like', 'categories.name', $this->name]);
        }

        return $dataProvider;
    }
}
