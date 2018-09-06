<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tracks;

/**
 * TracksSearch represents the model behind the search form of `frontend\models\Tracks`.
 */
class TracksSearch extends Tracks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'active', 'created_user', 'updated_user'], 'integer'],
            [['cover', 'url', 'artist_id', 'lyricist', 'composer', 'arrangement', 'lyrics', 'created_time', 'updated_time'], 'safe'],
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
        $query = Tracks::find()->where(['active' => 1]);

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
            'album_id' => $this->album_id,
            'active' => $this->active,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'created_user' => $this->created_user,
            'updated_user' => $this->updated_user,
        ]);

        $query->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'artist_id', $this->artist_id])
            ->andFilterWhere(['like', 'lyricist', $this->lyricist])
            ->andFilterWhere(['like', 'composer', $this->composer])
            ->andFilterWhere(['like', 'arrangement', $this->arrangement])
            ->andFilterWhere(['like', 'lyrics', $this->lyrics]);

        return $dataProvider;
    }
}
