<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Albums;

/**
 * AlbumsSearch represents the model behind the search form of `frontend\models\Albums`.
 */
class FansAlbumsSearch extends Albums
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language', 'type', 'active', 'created_user', 'updated_user'], 'integer'],
            [['album_name', 'album_description', 'cover', 'first_release_date', 'created_time', 'updated_time'], 'safe'],
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
        //$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        
        $query = Albums::find()->where(['active' => 1])->with('aImages');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                    //'created_time' => SORT_DESC, 
                ]
            ],
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
            'language' => $this->language,
            'type' => $this->type,
            'active' => $this->active,
            'first_release_date' => $this->first_release_date,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'created_user' => $this->created_user,
            'updated_user' => $this->updated_user,
        ]);

        $query->andFilterWhere(['like', 'album_name', $this->album_name])
            ->andFilterWhere(['like', 'album_description', $this->album_description])
            ->andFilterWhere(['like', 'cover', $this->cover]);

        return $dataProvider;
    }
}
