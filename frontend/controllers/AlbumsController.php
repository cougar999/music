<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Albums;
use frontend\models\AlbumsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Language;
use yii\helpers\ArrayHelper;
//use yii\web\UploadedFile;
use frontend\models\Images;
use frontend\models\Tracks;
use frontend\models\Genre;
use frontend\models\GenreBelongs;
use common\components\UploadedFile;
use common\components\AccessAuth;
use yii\data\ActiveDataProvider;
use yii\data\ActiveDataFilter;
use common\components\Helpers;
use frontend\models\Userevent;

/**
 * AlbumsController implements the CRUD actions for Albums model.
 */
class AlbumsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Albums models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlbumsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Albums model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $genres = [];
        $model = Albums::find()->where(['id' => $id])->with('aImages')->one();
        
        $auth = new AccessAuth;
        $auth->belong($model);

        $tracks = Tracks::find()->where(['album_id' => $id, 'active' => 1])->with(['allSounds', 'aImages'])->asArray()->all();
        $genreBelongs = GenreBelongs::find()->where(['owner_id' => $id, 'active' => 1, 'type' => 'album'])->with(['genreNames'])->asArray()->all();
        $language = ArrayHelper::map(Language::find()->asArray()->all(), 'id', 'value');

        foreach ($genreBelongs as $key => $value) {
            if (isset($value['genreNames']) && isset($value['genreNames'][0])) {
                $genres[$value['genreNames']['0']['id']] = $value['genreNames']['0']['name'];
            }
        }

        return $this->render('view', [
            //'model' => $this->findModel($id),
            'model' => $model,
            'tracks' => $tracks,
            'genres' => $genres,
            'language' => $language
        ]);
    }

    /**
     * Creates a new Albums model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Albums();
        $language = Language::find()->asArray()->all();
        $language = ArrayHelper::map($language, 'id', 'value');
        $genre = Genre::find()->asArray()->all();
        $genre = ArrayHelper::map($genre, 'id', 'name');

        if ($model->load(Yii::$app->request->post())){

            $post = Yii::$app->request->post();
            $time = Date("Y-m-d H:i:s");
            $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
            $today = Date("Y-m-d");

            $model->created_user = $userid;
            $model->created_time = $time;
            $model->updated_user = $userid;
            $model->updated_time = $time;
            $model->first_release_date = $post['Albums']['first_release_date'] ? date("Y-m-d", strtotime($post['Albums']['first_release_date'])) : $today;


            if($model->save()) {
                
                $genre_post = isset($post['Albums']['genre']) ? $post['Albums']['genre'] : [] ;
                if(isset($genre_post) && $genre_post >= 1){
                    foreach ($genre_post as $value) {
                        $gb = new GenreBelongs;
                        $gb->owner_id = $model->id;
                        $gb->genre_id = $value;
                        $gb->type = 'album';
                        $gb->save();
                    }
                }

                $upload = new UploadedFile;
                $img = $upload->UploadImage($model, 'cover', 'album');

                //user event
                $helpers = new Helpers;
                $event = $helpers->userEvent($model->id, 'album');

                return $this->redirect(['view', 'id' => $model->id]);
                
            }
        }

        return $this->render('create', [
            'model' => $model,
            'language' => $language,
            'image' => isset($image) ? $image : [],
            'genre' => $genre
        ]);

    }

    /**
     * Updates an existing Albums model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $auth = new AccessAuth;
        $auth->belong($model);

        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $language = Language::find()->asArray()->all();
        $language = ArrayHelper::map($language, 'id', 'value');
        $image = Images::find()->where(['source_id' => $id, 'user_id' => $userid, 'type' => 'album'])->orderBy('id DESC')->one();
        $genre = ArrayHelper::map(Genre::find()->asArray()->all(), 'id', 'name');
        $genre_list = GenreBelongs::find()->where(['type' => 'album', 'owner_id' => $id])->asArray()->all();
        $genre_list = ArrayHelper::map($genre_list, 'id', 'genre_id');
        $model->genre = array_values($genre_list);

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            //var_dump($post);die;
            if(isset($post)){
                
                //var_dump($post);
                $upload = new UploadedFile;

                //delete cover image when a hidden input set to delete
                $action = isset($post['cover_action']) ? $post['cover_action'] : '';

                $img = $upload->UploadImage($model, 'cover', 'album', $action);

            }

            $time = Date("Y-m-d H:i:s");
            $model->updated_user = $userid;
            $model->updated_time = $time;


            $model->first_release_date = $post['Albums']['first_release_date'] ? date("Y-m-d", strtotime($post['Albums']['first_release_date'])) : $today;

            $genre_post = isset($post['Albums']['genre']) ? $post['Albums']['genre'] : [] ;
            if (NULL != $genre_post && count($genre_post) >= 1) {
                foreach ($genre_post as $items) {
                    if (!in_array($items, array_values($genre_list))) {
                        $gb = new GenreBelongs;
                        $gb->owner_id = $model->id;
                        $gb->genre_id = $items;
                        $gb->type = 'album';
                        $gb->save();
                    }
                }
                
                foreach ($genre_list as $content) {
                    if (!in_array($content, $genre_post)) {
                        $remove = GenreBelongs::find()->where(['genre_id' => $content, 'owner_id' => $model->id, 'type' => 'album'])->one();

                        $remove->delete();
                    }
                }
            } else {
                $removeall = GenreBelongs::find()->where(['owner_id' => $model->id, 'type' => 'album'])->all();
                if (isset($removeall) && count($removeall) >= 1) {
                     GenreBelongs::deleteAll(['owner_id' => $model->id, 'type' => 'album']);
                }
                
            }

            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'language' => $language,
            'image' => isset($image) ? $image : [],
            'genre' => $genre,
        ]);
    }

    /**
     * Deletes an existing Albums model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $auth = new AccessAuth;
        $auth->belong($model);
        
        if (isset($model) && NULL != $model) {
            $model->active = 0;
            $helper = new Helpers;
            $del = $helper->clearAblums($id);
            var_dump($del);

            $model->save();
        }
        //return $this->redirect(['index', 'id' => $model->album_id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Albums model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Albums the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Albums::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
