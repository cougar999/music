<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\Albums;
use frontend\models\FansAlbumsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Language;
use yii\helpers\ArrayHelper;
use common\components\AccessAuth;
use frontend\models\Tracks;
use frontend\models\Genre;
use frontend\models\GenreBelongs;
use frontend\models\Images;
use frontend\models\Likes;
use frontend\models\Counter;
use frontend\models\Follow;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use dektrium\user\Finder;
use common\components\Helpers;
use yii\data\ActiveDataProvider;

class GenreController extends \yii\web\Controller
{
    public function actionIndex($id = null)
    {
    	if ($id) {
    		$album_ids = [];
    		$genre = Genre::findOne($id);
    		$albumIds = GenreBelongs::find()->where(['type'=>'album', 'active' => 1, 'genre_id' => $id])->all();
    		if (isset($albumIds) && count($albumIds) > 0) {
	            $album_ids = array_keys(ArrayHelper::index($albumIds, function ($element) {
	                return $element['owner_id'];
	            }));
	        }

    		$query = Albums::find()->where(['id' => $album_ids, 'active' => 1]);

	        $dataProvider = new ActiveDataProvider([
	            'query' => $query,
	            'pagination' => [
	                'pageSize' => 12,
	            ],
	            'sort' => [
	                'defaultOrder' => [
	                    'id' => SORT_DESC,
	                ]
	            ],
	        ]);

	        return $this->render('index', ['model' => $genre, 'dataProvider' => $dataProvider]);

    	} else {
    		$genre = Genre::find()->all();
    		
    		return $this->render('index', ['model' => $genre]);
    	}

        
    }

}
