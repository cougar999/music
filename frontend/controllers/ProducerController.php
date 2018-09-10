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
use frontend\models\User;
use frontend\models\Profile;
use frontend\models\Userevent;
use dektrium\user\Finder;
use common\components\Helpers;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * Site controller
 */
class ProducerController extends Controller
{
    
    protected $finder;
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }
    
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new FansAlbumsSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $album_ids = [];
        $welcome_artist_ids = [];
        $fav_artist_ids = [];
        $contents = [];
        $pop_songs = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        
        $helpers = new Helpers;
        $country = $helpers->getCountries();
        $city = $helpers->getCities();

        if (Yii::$app->user && Yii::$app->user->identity) {
            $join_date = date('d-M-Y', Yii::$app->user->identity->created_at);
            $user = Yii::$app->user->identity;
        }
        $artist['user'] = $this->finder->findUserById($userid)->getAttributes();
        $profile = $this->finder->findProfileById($userid);
            if(NULL != $profile) {
                $artist['profile'] = $this->finder->findProfileById($userid)->getAttributes();    
            } else {
                $artist['profile'] = [];
            }
        $follow_number = Counter::find()->where(['source_id' => $userid, 'type' => 'follow'])->one();
        $events = Userevent::find()->where(['created_user' => $userid])->orderBy('created_time DESC')->all();

        $followed = Follow::find()->where(['created_user' => $userid])->all();
        $followeds = [];
        if (isset($followed) && count($followed) > 0) {
            $followeds = array_keys(ArrayHelper::index($followed, function ($element) {
                return $element['source_id'];
            }));
        }
       

        if (isset($events) && count($events) > 0) {
            
            foreach ($events as $key => $value) {
                $contents[$key] = ArrayHelper::toArray($value);
                if ($value->type == 'album') {

                    $contents[$key]['related'] = Albums::find()->where(['id'=> $value->source_id])->with('aImages')->asArray()->one();
                    //$contents[$key]['theimages'] = Images::find()->where(['source_id'=> $value->source_id])->asArray()->one();

                } elseif ($value->type == 'track') {
                    
                    $contents[$key]['related'] = Tracks::find()->where(['id'=> $value->source_id])->asArray()->one();

                } elseif ($value->type == 'like') {
                    $like = Likes::find()->where(['id'=> $value->source_id])->one();

                    if (isset($like) && $like->type == 'album') {
                        $contents[$key]['liketype'] = 'album';
                        $contents[$key]['related'] = Albums::find()->where(['id'=> $like->source_id])->with('aImages')->asArray()->one();
                    } else {
                        $contents[$key]['liketype'] = 'track';
                        $contents[$key]['related'] = Tracks::find()->where(['id'=> $like->source_id])->asArray()->one();
                    }
                    
                } elseif ($value->type == 'follow') {
                    $contents[$key]['related']  = Follow::find()->where(['id'=> $value->source_id])->with('userProfile')->asArray()->one();
                }
               
            }
            //var_dump($contents);

        }

        $counters = Counter::find()->where(['active' => 1, 'type' => 'like', 'cate' => 'album'])->orderBy('count DESC')->limit(12)->all();
              
        if (isset($counters) && count($counters) > 0) {
            $album_ids = array_keys(ArrayHelper::index($counters, function ($element) {
                return $element['source_id'];
            }));
        }
        $query = Albums::find()->where(['albums.id' => $album_ids]);
        $query->joinWith(['clicks'])->orderBy('counter.count DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        // for most welcome artists
        $counters_artist = Counter::find()->where(['active' => 1, 'type' => 'follow', 'cate' => 'artist'])->orderBy('count DESC')->limit(12)->all();
        if (isset($counters_artist) && count($counters_artist) > 0) {
            $welcome_artist_ids = array_keys(ArrayHelper::index($counters_artist, function ($element) {
                return $element['source_id'];
            }));
        }

        $wel_artist_query = User::find()->where(['id' => $welcome_artist_ids])->with('userProfile', 'userPhoto');

        $wel_artist_Provider = new ActiveDataProvider([
            'query' => $wel_artist_query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);


        // for popular songs
        $likes_count = Counter::find()->where(['type' => 'like', 'cate' => 'track', 'active' => 1])->with('tracks')->orderBy('count DESC')->limit(10)->all();
        //$likes_count = Counter::find()->where(['type' => 'like', 'cate' => 'track', 'active' => 1])->orderBy('count DESC')->limit(10)->all();

        if (isset($likes_count) && count($likes_count) > 0) {
            $pop_songs = array_keys(ArrayHelper::index($likes_count, function ($element) {
                return $element['source_id'];
            }));
        }

        $popular_songs = Tracks::find()->where([ 'tracks.id'=> $pop_songs ]);///->with('allSounds', 'clicks');

        $popular_songs->joinWith(['clicks'])->orderBy('counter.count DESC');

        $pop_songs_Provider = new ActiveDataProvider([
            'query' => $popular_songs,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);



        // for most favorite  artists
        $counters_fav_artist = Counter::find()->where(['active' => 1, 'type' => 'like', 'cate' => 'artist'])->orderBy('count DESC')->limit(8)->all();
        if (isset($counters_fav_artist) && count($counters_fav_artist) > 0) {
            $fav_artist_ids = array_keys(ArrayHelper::index($counters_fav_artist, function ($element) {
                return $element['source_id'];
            }));
        }

        $fav_artist_query = User::find()->where(['id' => $fav_artist_ids])->with('userProfile', 'userPhoto');

        $fav_artist_Provider = new ActiveDataProvider([
            'query' => $fav_artist_query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'date' => $join_date, 
            'user' => $user,
            'artist' => $artist,
            'follow_number' => $follow_number,
            'country' => $country,
            'city' => $city,
            'contents' => $contents,
            'dataProvider' => $dataProvider,
            'welArtistProvider' => $wel_artist_Provider,
            'favArtistProvider' => $fav_artist_Provider,
            'popSongsProvider' => $pop_songs_Provider,
            //'popsongslist' => $pop_songs_list,
            'title' => 'Producer Homepage',
            'userid' => $userid,
        ]);
        //return $this->render('index', ['title' => 'Alex']);
        //return $this->render('smarty.tpl', ['username' => 'Alex']);
        //return $this->redirect(['/starter']);
    }

    /*
    public function actionAlbumView($id)
    {
        
        $genres = [];
        $author =[];
        $like_tracks = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $model = Albums::find()->where(['id' => $id])->with('aImages')->one();
        
        $tracks = Tracks::find()->where(['album_id' => $id, 'active' => 1])->with(['allSounds', 'aImages'])->asArray()->all();
        $genreBelongs = GenreBelongs::find()->where(['owner_id' => $id, 'active' => 1, 'type' => 'album'])->with(['genreNames'])->asArray()->all();
        $language = ArrayHelper::map(Language::find()->asArray()->all(), 'id', 'value');
        $like = Likes::find()->where(['source_id' => $model->id, 'created_user' => $userid, 'type' => 'album'])->orderBy('id DESC')->one();
        $like_number = Counter::find()->where(['source_id' => $model->id, 'type' => 'like', 'cate' => 'album'])->one();

        if (isset($genreBelongs)) {
            foreach ($genreBelongs as $key => $value) {
                if (isset($value['genreNames']) && isset($value['genreNames'][0])) {
                    $genres[$value['genreNames']['0']['id']] = $value['genreNames']['0']['name'];
                }
            }
        }
        

        $all_like_tracks = Likes::find()->where(['created_user' => $userid, 'type' => 'track'])->orderBy('id ASC')->asArray()->all();

        if(isset($all_like_tracks)) {
            foreach ($all_like_tracks as $v) {
                $like_tracks[$v['source_id']] = $v;
            }
            
        }

        if (isset($model) && isset($model->created_user)) {
            $author['user'] = $this->finder->findUserById($model->created_user)->getAttributes();
            $author['profile'] = $this->finder->findProfileById($model->created_user)->getAttributes();
        }
        
        return $this->render('album-view', [
            //'model' => $this->findModel($id),
            'model'         =>  $model,
            'tracks'        =>  $tracks,
            'genres'        =>  $genres,
            'language'      =>  $language,
            'author'        =>  $author,
            'like'          =>  $like,
            'like_number'   =>  $like_number,
            'like_tracks'   =>  $like_tracks
        ]);
    }

    public function actionArtistBio($artist_id)
    {
        
        if(!isset($artist_id)) return;
        $artist = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $artist['user'] = $this->finder->findUserById($artist_id)->getAttributes();
        $artist['profile'] = $this->finder->findProfileById($artist_id)->getAttributes();
        $helpers = new Helpers;
        $country = $helpers->getCountries();
        $city = $helpers->getCities();

        $albums = Albums::find()->where(['created_user' => $artist_id, 'active' => 1])->with('aImages')->orderBy('id DESC')->limit(6)->all();

        $follow = Follow::find()->where(['source_id' => $artist_id, 'created_user' => $userid, 'type' => 'artist'])->orderBy('id DESC')->one();
        $follow_number = Counter::find()->where(['source_id' => $artist_id, 'type' => 'follow'])->one();
        

        return $this->render('artist-bio', [
            //'model' => $this->findModel($id),
            'artist'        => $artist,
            'city'          => $city,
            'country'       => $country,
            'albums'        => $albums,
            'follow'        => $follow,
            'follow_number' => $follow_number

        ]);

    }

    public function actionSetaction()
    {
        $request = Yii::$app->request->post();
        $source_id = $request['sourceid'] ? $request['sourceid'] : 0;
        $cate = $request['cate'] ? $request['cate'] : 0;
        $action = $request['action'] ? $request['action'] : 0;

        $helper = new Helpers;

        if ($action == 'like') {
            $result = $helper->like($source_id, $cate);
            if (isset($result)) {
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

    public function actionFollowing()
    {
        return $this->redirect(['site/following']);

        $user_ids = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $follow = Follow::find()->where(['created_user' => $userid, 'active' => 1, 'type' => 'artist'])->asArray()->all();
        if (isset($follow) && count($follow) > 0) {
            $user_ids = array_keys(ArrayHelper::index($follow, function ($element) {
                return $element['source_id'];
            }));
        }
        
        $query = Albums::find()->where(['created_user' => $user_ids, 'active' => 1])->with('aImages');

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

        return $this->render('following', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Following'
        ]);
    }

    public function actionTrending()
    {
        
        $album_ids = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $counters = Counter::find()->where(['active' => 1, 'type' => 'like', 'cate' => 'album'])->orderBy('count DESC')->all();
        
        if (isset($counters) && count($counters) > 0) {
            $album_ids = array_keys(ArrayHelper::index($counters, function ($element) {
                return $element['source_id'];
            }));
        }

        $query = Albums::find()->where(['id' => $album_ids, 'active' => 1])->with('aImages');

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

        return $this->render('following', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Trending (Most likes)'
        ]);
    }
    */

}
