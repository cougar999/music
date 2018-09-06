<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Genre;
use frontend\models\GenreBelongs;
use frontend\models\GenreLikes;
use frontend\models\Albums;
use frontend\models\Tracks;
use yii\helpers\ArrayHelper;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use dektrium\user\Finder;
use frontend\models\Likes;
use frontend\models\Follow;
use frontend\models\Counter;
use common\components\Helpers;
use frontend\models\Playlist;


class StarterController extends Controller
{
	protected $finder;
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $genre = [];
        $genre_ids = [];
        $indexed_genre = [];
        
        $edit = 0;

        $request = Yii::$app->request->get();
        if (isset($request) && isset($request['edit'])) {
            $edit = $request['edit'];
        }
    	if (isset(Yii::$app->user->identity) && NULL != Yii::$app->user->identity) {
		    $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
		} else{
		    $userid = 0;
		}

        $genre = Genre::find()->all();
        $genre_likes = GenreLikes::find()->where(['owner_user_id' => $userid])->asArray()->all();
        $genre_ids = ArrayHelper::map($genre_likes, 'id', 'genre_id');

        $indexed_genre = ArrayHelper::index($genre, 'id');

        

        $post = [];
        $rows = []; 
        
        if (Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            GenreLikes::deleteAll(['owner_user_id' => $userid]);
            if (isset($post) && isset($post['genre'])) {
                
                foreach ($post['genre'] as $val) {
                    if ($val) { 
                        //$rows[] = $val->attributes;
                        $rows[] = [ 
                            'genre_id' => $val, 
                            'owner_user_id' => $userid, 
                        ]; 
                    } 
                }
                if (Yii::$app->db->createCommand()->batchInsert(GenreLikes::tableName(), 
                ['genre_id', 'owner_user_id'], $rows)->execute() > 0) {

                    return $this->redirect(['listen']);

                }
            }
            
        }

        if ((isset($genre_likes) && count($genre_likes) > 0) && !$edit) {
            return $this->redirect(['listen']);
        }
        

        return $this->render('index', ['model' => $genre, 'genre_ids' => $genre_ids, 'indexed_genre' => $indexed_genre]);

        /*if (Yii::$app->user->can('artist')) {
            $genre = [];
            // echo "artist";
        }
        else if (Yii::$app->user->can('fans')) {
            // echo "fans";
        }
        else if (Yii::$app->user->can('producer')) {
            $genre = [];
            // echo "producer";
        } */

        //return $this->render('index', ['model' => $genre]);
    }


    public function actionListen()
    {
        $like_tracks = [];
    	if (isset(Yii::$app->user->identity) && NULL != Yii::$app->user->identity) {
		    $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
		} else{
		    $userid = 0;
		}

		$genre_likes = GenreLikes::find()->where(['owner_user_id' => $userid])->asArray()->all();
        if (!isset($genre_likes) || (isset($genre_likes) && count($genre_likes) < 1)) {
            return $this->redirect(['index']);
        }
		$genre_ids = ArrayHelper::map($genre_likes, 'id', 'genre_id');

    	// find albums with the genre ids
    	$genreBelongs = GenreBelongs::find()->where(['genre_id' => $genre_ids, 'active' => 1])->asArray()->all();
    	//$genreBelongs_ids = ArrayHelper::map($genreBelongs, 'id', 'genre_id');

    	$album_ids = ArrayHelper::getColumn($genreBelongs, 'owner_id');
    	if (isset($album_ids) && count($album_ids) > 0) {
    		$purified_album_ids = array_unique($album_ids);
    	}

        $playlist = Playlist::find()->where(['created_user' => $userid, 'active' => 1])->all();

        $all_like_tracks = Likes::find()->where(['created_user' => $userid, 'type' => 'track'])->orderBy('id ASC')->asArray()->all();

        if (isset($all_like_tracks) && count($all_like_tracks) > 0) {
            $like_tracks = array_keys(ArrayHelper::index($all_like_tracks, function ($element) {
                return $element['source_id'];
            }));
        }
        
    	$range = 1;
    	$roll = 1;
    	$id = 1;
        $like = [];
        $like_number = [];
    	$author = [];
    	if (isset($album_ids) && count($album_ids) > 0) {
    		$range = count($album_ids) - 1;
    		$roll = rand(0, $range);
    		
    	}
    	if (isset($roll) && isset($album_ids) && count($album_ids) > 0)  {
    		$album = Albums::find()->where(['id' => $album_ids[$roll], 'active' => 1])->with('aImages')->one();
    		$tracks = Tracks::find()->where(['album_id' => $album->id, 'active' => 1])->with(['allSounds'])->asArray()->all();
            $like = Likes::find()->where(['source_id' => $album->id, 'created_user' => $userid, 'type' => 'album'])->orderBy('id DESC')->one();
            $like_number = Counter::find()->where(['source_id' => $album->id, 'type' => 'like', 'cate' => 'album'])->one();
            $follow = Follow::find()->where(['source_id' => $album->created_user, 'created_user' => $userid, 'type' => 'artist'])->orderBy('id DESC')->one();
            $follow_number = Counter::find()->where(['source_id' => $album->created_user, 'type' => 'follow'])->one();

    		if (isset($album) && isset($album->created_user)) {
	            $author['user'] = $this->finder->findUserById($album->created_user)->getAttributes();
	            $profile = $this->finder->findProfileById($album->created_user);
                if(NULL != $profile) {
                    $author['profile'] = $this->finder->findProfileById($album->created_user)->getAttributes();    
                } else {
                    $author['profile'] = [];
                }
	        }
    	} else {
    		$album = [];
    		$tracks = [];
    		$author = [];

    	}
        if(isset($purified_album_ids) && count($purified_album_ids) > 0) {
            $albums = Albums::find()->where(['id' => $purified_album_ids, 'active' => 1])->with('aImages')->all();
            
        } else {
            $albums = [];
        }

        // Yii::$app->db->close();
        
		return $this->render('listen', [
            'album_ids' => $album_ids, 
            'model' => $album, 
            'tracks' => $tracks, 
            'author' => $author, 
            'albums' => $albums,
            'like'  => $like,
            'like_number' => $like_number,
            'follow' => $follow,
            'follow_number' => $follow_number,
            'userid' => $userid,
            'playlist' => $playlist,
            'like_tracks' => $like_tracks
        ]);
    }

    public function actionSetaction()
    {
        $request = Yii::$app->request->post();
        if (!isset($request) || !isset($request['sourceid']) || !isset($request['cate']) || !isset($request['action'])) {
            return 0;
        }
        $source_id = $request['sourceid'] ? $request['sourceid'] : 0;
        $cate = $request['cate'] ? $request['cate'] : 0;
        $action = $request['action'] ? $request['action'] : 0;

        $helper = new Helpers;

        if ($action == 'like') {
            $result = $helper->like($source_id, $cate);
            if (isset($result)) {
            //var_dump($result);die;
                echo json_encode($result->getAttributes());
            } else {
                echo 0;
            }
        } elseif ($action == 'follow') {
            $result = $helper->follow($source_id, $cate);
            if (isset($result)) {
                echo json_encode($result->getAttributes());
            } else {
                echo 0;
            }
        }
        
    }

}


