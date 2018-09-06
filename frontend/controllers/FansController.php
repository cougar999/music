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

/**
 * Site controller
 */
class FansController extends Controller
{
    /*
    protected $finder;
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }*/
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
        $searchModel = new FansAlbumsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->redirect(['/starter']);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'title' => 'NEW RELEASE'
        // ]);
        //return $this->render('smarty.tpl', ['username' => 'Alex']);
    }

}
