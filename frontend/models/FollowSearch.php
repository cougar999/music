<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Follow;

/**
 * FollowSearch represents the model behind the search form of `frontend\models\Follow`.
 */
class FollowSearch extends Follow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'active', 'created_user', 'updated_user'], 'integer'],
            [['type', 'created_time', 'updated_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Follow::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'source_id' => $this->source_id,
            'active' => $this->active,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'created_user' => $this->created_user,
            'updated_user' => $this->updated_user,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
