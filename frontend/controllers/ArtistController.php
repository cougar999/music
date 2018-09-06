<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\Likes;
use frontend\models\Counter;
use frontend\models\Follow;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use dektrium\user\Finder;
use common\components\Helpers;
use frontend\models\Albums;
use frontend\models\Tracks;
use frontend\models\Images;
use frontend\models\Userevent;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class ArtistController extends Controller
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
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $user = [];
        $contents = [];
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
        //$events = Userevent::find()->where(['created_user' => $userid])->with('related')->orderBy('created_time DESC')->all();
        $events = Userevent::find()->where(['created_user' => $userid])->orderBy('created_time DESC')->all();
        $albums = Albums::find()->where(['created_user' => $userid, 'active' => 1])->with('aImages')->orderBy('id DESC')->limit(18)->all();

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
        // $like_number = Counter::find()->where(['source_id' => $userid, 'type' => 'like', 'cate' => 'artist'])->one();
        // $follow_number = Counter::find()->where(['source_id' => $userid, 'type' => 'follow', 'cate' => 'artist'])->one();
        // $album_number = Albums::find()->where(['created_user' => $userid])->count();

        return $this->render('index', [
            'date' => $join_date, 
            'user' => $user,
            'events' => $events,
            'contents' => $contents,
            'artist' => $artist,
            'city' => $city,
            'country' => $country,
            'follow_number' => $follow_number,
            'albums' => $albums
        ]);
        //return $this->render('smarty.tpl', ['username' => 'Alex']);
    }

}
