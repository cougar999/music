<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\components\UploadedFile;
use common\components\AccessAuth;
use frontend\models\Images;
use yii\helpers\Url;

use frontend\models\Albums;
use frontend\models\Language;
use yii\helpers\ArrayHelper;
use frontend\models\Tracks;
use frontend\models\Genre;
use frontend\models\GenreBelongs;
use frontend\models\Likes;
use frontend\models\Counter;
use frontend\models\Follow;
use frontend\models\User;
use frontend\models\Profile;
use dektrium\user\Finder;
use common\components\Helpers;
use yii\data\ActiveDataProvider;
use frontend\models\FansAlbumsSearch;

use johnnylei\message_system\Message;
use johnnylei\message_system\MessageQueueSubscription;
use frontend\models\MessageManager;
use frontend\models\Userevent;
/**
 * Site controller
 */
class SiteController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

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
        $this->layout = 'layout_index';
        $query = Albums::find()->where(['active' => 1])->limit(4)->with('aImages');
        $latest_albums = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);


        return $this->render('index',[
            'latest_albums' => $latest_albums,
        ]);
        //return $this->render('smarty.tpl', ['username' => 'Alex']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPhoto()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('../user/login');
        }

        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $model = Images::find()->where(['user_id' => $userid, 'source_id' => $userid, 'type' => 'avatar'])->orderBy('id DESC')->one();

        if (!isset($model) && count($model) < 1) {
            $model = new Images;
        }

        $weburl = Url::to("@web");

        // $auth = new AccessAuth;
        // $auth->belong($model);

        $post = Yii::$app->request->isPost;
        if ($post) {

            if (isset($_FILES['croppedImage']) && !empty($_FILES['croppedImage'])) {

                $filename_short = Yii::$app->security->generateRandomString();

                $path = Yii::$app->basePath . '/web/uploads/'.$userid;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);         
                }
                $avatarPath = $path.'/avatar/';
                if (!file_exists($avatarPath)) {
                    mkdir($avatarPath, 0777, true);         
                }
                if (move_uploaded_file($_FILES['croppedImage']['tmp_name'], $path.'/avatar/'.$filename_short.'.jpg')) {
                    $model->filename = $filename_short;
                    $model->url = '/frontend/web/uploads/'.$userid.'/avatar/';
                    $model->ext = 'jpg';
                    $model->source_id = $userid;
                    $model->user_id = $userid;
                    $model->type = 'avatar';
                    if ($model->save()) {
                        $result = json_encode('[{"result":1, "url":"'.$weburl.'/frontend/web/uploads/'.$userid.'/avatar/'.$filename_short.'.jpg"}]');
                    }

                } else {
                    $result = json_encode('[{"result": 0}]');
                }
            } else {
                $result = json_encode('[{"result": -1}]');
            }
            
            echo $result;
            exit();
            
        }
        return $this->render('photo', ['model' => $model, 'userid' => $userid]);
    }

    public function actionNew()
    {
        $searchModel = new FansAlbumsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('new', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'NEW RELEASE'
        ]);
    }

    public function actionFollowing()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect('../user/login');
        }

        $user_ids = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $follow = Follow::find()->where(['created_user' => $userid, 'active' => 1, 'type' => 'artist'])->with('userProfile', 'userPhoto');

        $dataProvider = new ActiveDataProvider([
            'query' => $follow,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        if (isset($dataProvider) && count($dataProvider) > 0) {
            $item = ArrayHelper::toArray($dataProvider->getModels());
            $user_ids = array_keys(ArrayHelper::index($item, function ($element) {
                return $element['source_id'];
            }));
        }

        return $this->render('following', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Following'
        ]);
    }

    public function actionAlbumView($id)
    {
        
        $genres = [];
        $author =[];
        $like_tracks = [];
        $userid = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
        $model = Albums::find()->where(['id' => $id])->with('aImages')->one();
        
        $tracks = Tracks::find()->where(['album_id' => $id, 'active' => 1])->with(['allSounds', 'clicks'])->asArray()->all();
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
            $profile = $this->finder->findProfileById($model->created_user);
            if(NULL != $profile) {
                $author['profile'] = $this->finder->findProfileById($model->created_user)->getAttributes();    
            } else {
                $author['profile'] = [];
            }
        }
        //\Yii::$app->controller->view->registerMetaTag(['property'=>'og:title', 'content'=>'xxx'], 'og:title');

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
        if (Yii::$app->user->isGuest) {
            return $this->redirect('../user/login');
        }
        $artist = [];
        $contents = [];
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $artist['user'] = $this->finder->findUserById($artist_id)->getAttributes();
        $profile = $this->finder->findProfileById($artist_id);
            if(NULL != $profile) {
                $artist['profile'] = $this->finder->findProfileById($artist_id)->getAttributes();    
            } else {
                $artist['profile'] = [];
            }
        $helpers = new Helpers;
        $country = $helpers->getCountries();
        $city = $helpers->getCities();

        $albums = Albums::find()->where(['created_user' => $artist_id, 'active' => 1])->with('aImages')->orderBy('id DESC')->limit(18)->all();

        $follow = Follow::find()->where(['source_id' => $artist_id, 'created_user' => $userid, 'type' => 'artist'])->orderBy('id DESC')->one();
        $follow_number = Counter::find()->where(['source_id' => $artist_id, 'type' => 'follow'])->one();

        $like = Likes::find()->where(['source_id' => $artist_id, 'created_user' => $userid, 'type' => 'artist'])->orderBy('id DESC')->one();
        $like_number = Counter::find()->where(['source_id' => $artist_id, 'type' => 'like', 'cate' => 'artist'])->one();

        $artist_bio = User::find()->where(['id' => $artist_id])->with('userProfile', 'userPhoto')->one();

        $events = Userevent::find()->where(['created_user' => $artist_id])->orderBy('created_time DESC')->all();
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

        }

        return $this->render('artist-bio', [
            'artist'        => $artist,
            'city'          => $city,
            'country'       => $country,
            'albums'        => $albums,
            'follow'        => $follow,
            'follow_number' => $follow_number,
            'like'          => $like,
            'like_number'   => $like_number,
            'artist_bio'    => $artist_bio,
            'contents'      => $contents,

        ]);

    }

    public function actionTrending()
    {
        
        $album_ids = [];
        //$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

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

        return $this->render('trending', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => 'Trending (Most likes)'
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

    public function actionMessage()
    {
        //$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $sender = new MessageManager;
        $messageList = $sender->myMessageList();
        //$news = $sender->newMessageCount();
        //$receive = $sender->receive();
        
        if (isset($messageList['list']) && count($messageList['list']) >0) {
            foreach ($messageList['list'] as $key => $value) {
                $messageList['list'][$key]['user'] = User::find()->where(['id' => $value['producer']])->with('userProfile', 'userPhoto')->one();
            }
        }

        var_dump($messageList);
        return $this->render('message', ['messageList' => $messageList]);
    }

    public function actionHandlemessage()
    {
        $request = Yii::$app->request->post();
        $msgid = $request['msgid'] ? $request['msgid'] : 0;
        $action = $request['action'] ? $request['action'] : 0;

        $helper = new Helpers;

        if ($action == 'read') {
            $result = $helper->readMessage($msgid);
            if (isset($result)) {
                echo $result;
            } else {
                echo 0;
            }
        } elseif ($action == 'remove') {
            $result = $helper->removeMessage($msgid);
            if (isset($result)) {
                echo $result;
            } else {
                echo 0;
            }
        }
        
    }

    public function actionGetnewmsgcount()
    {
        $request = Yii::$app->request->post();
        $_count = $request['count'] ? $request['count'] : 0;
        $helper = new Helpers;
        if ($_count) {
            set_time_limit(0); 
            while (true){

                session_write_close();
                
                $count = $helper->getMessageCount();
                if (isset($count) && $count > 0 && $count > $_count) {
                    echo $count;
                    break;
                }
                sleep(10);
            }
        }

    }


}
