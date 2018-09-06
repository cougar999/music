<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Playlist;

/**
 * PlaylistSearch represents the model behind the search form of `frontend\models\Playlist`.
 */
class PlaylistSearch extends Playlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'created_user', 'updated_user'], 'integer'],
            [['name', 'note', 'created_time', 'updated_time'], 'safe'],
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
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $query = Playlist::find()->where(['created_user' => $userid]);

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
            'active' => $this->active,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'created_user' => $this->created_user,
            'updated_user' => $this->updated_user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
