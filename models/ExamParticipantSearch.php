<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExamParticipant;

/**
 * ExamParticipantSearch represents the model behind the search form of `app\models\ExamParticipant`.
 */
class ExamParticipantSearch extends ExamParticipant
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','status'], 'safe'],
            [['id', 'exam_id', 'participant_id'], 'integer'],
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
        $query = ExamParticipant::find();

        // add conditions that should always apply here
        $query->joinWith(['participant']);

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
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'participant_id' => $this->participant_id,
        ]);

        $query->andFilterWhere([
            'participants.name' => $this->name,
        ]);

        return $dataProvider;
    }
}
