<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Playlist;
use frontend\models\PlaylistSearch;
use frontend\models\PlaylistRelations;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\models\Tracks;
/**
 * PlaylistController implements the CRUD actions for Playlist model.
 */
class PlaylistController extends Controller
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
     * Lists all Playlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaylistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Playlist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $tracks = PlaylistRelations::find()->where(['playlist_id' => $id])->with('tracks')->orderBy(['order' => SORT_DESC])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'tracks' => $tracks,
            'userid' => $userid
        ]);
    }

    /**
     * Creates a new Playlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Playlist();
        $model->public = 0;

        $time = Date("Y-m-d H:i:s");
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $today = Date("Y-m-d");


        if ($model->load(Yii::$app->request->post())){

            $model->created_user = $userid;
            $model->created_time = $time;
            $model->updated_user = $userid;
            $model->updated_time = $time;

            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Playlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Playlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Playlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Playlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Playlist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionList()
    {
        $this->layout = 'blank';
        $searchModel = new PlaylistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateinlist()
    {
        $this->layout = 'blank';
        $model = new Playlist();
        $model->public = 0;

        $time = Date("Y-m-d H:i:s");
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $today = Date("Y-m-d");


        if ($model->load(Yii::$app->request->post())){

            $model->created_user = $userid;
            $model->created_time = $time;
            $model->updated_user = $userid;
            $model->updated_time = $time;

            if($model->save()) {
                return $this->redirect(['list']);
            } else {
                var_dump($model->getErrors());
            }
        }

        return $this->render('createinlist', [
            'model' => $model,
        ]);
    }

    public function actionPlaylistaction()
    {
        $request = Yii::$app->request->post();
        if (!isset($request) || !isset($request['trackid']) || !isset($request['playlist'])) {
            return 0;
        }
        $trackid = $request['trackid'] ? $request['trackid'] : 0;
        $playlist = $request['playlist'] ? $request['playlist'] : 0;

        $model = PlaylistRelations::find()->where(['track_id' => $trackid, 'playlist_id' => $playlist])->one();

        if (!isset($model)) {
            $model = new PlaylistRelations;
        } else {
            if ($playlist == $model->playlist_id) {
                $result = '{"code":"2","message":"This song is already in this playlist."}';
                echo json_encode($result); //exist
                exit();
            }
        }

        $model->track_id = $trackid;
        $model->playlist_id = $playlist;
        $model->created_time = Date("Y-m-d H:i:s");
        if ($model->save()) {
            $result = '{"code":"1","message":"Saved."}';
            echo json_encode($result); //exist
            exit();
        } else {
            $result = '{"code":"0","message":"Something is not right, please try again later."}';
            echo json_encode($result); //exist
            exit();
        }

    }

    public function actionGetuserplaylist()
    {
        if (Yii::$app->user->isGuest) {
            return 0;
        }
        $request = Yii::$app->request->post();

        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $model = Playlist::find()->where(['created_user' => $userid, 'active' => 1])->asArray()->all();

        echo json_encode($model);

    }

    public function actionGetsongs()
    {
        $request = Yii::$app->request->post();

        if (isset($request) && $request['playlist']) {
            $playlist = $request['playlist'];
        } else {
            return 0;
        }
        
        $related_songs = PlaylistRelations::find()->where(['playlist_id' => $playlist])->orderBy('order DESC')->asArray()->all();

        if (!isset($related_songs)) {
            return 0;
        }

        $songids = ArrayHelper::map($related_songs, 'track_id', 'order');

        if (!isset($songids)) { return 0; }

        $songs = array_keys($songids);

        $tracks = Tracks::find()->where(['id' => $songs, 'active' => 1])->asArray()->all();

        if (!isset($tracks) || count($tracks) < 1) { return 0; }

        $result = ArrayHelper::index($tracks, function ($element) {
            return base64_encode(base64_encode($element['id'] .'-'.$element['name']));
        });

        if (!isset($result)) { return 0; }
        //var_dump($result);die();
        //$model = Playlist::find()->where(['created_user' => $userid, 'active' => 1])->asArray()->all();

        echo json_encode($result);

    }


}
