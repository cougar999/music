<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PlaylistRelations;

/**
 * PlaylistRelationsSearch represents the model behind the search form of `frontend\models\PlaylistRelations`.
 */
class PlaylistRelationsSearch extends PlaylistRelations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'track_id', 'playlist_id', 'order'], 'integer'],
            [['created_time'], 'safe'],
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
        $query = PlaylistRelations::find();

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
            'track_id' => $this->track_id,
            'playlist_id' => $this->playlist_id,
            'order' => $this->order,
            'created_time' => $this->created_time,
        ]);

        return $dataProvider;
    }
}
