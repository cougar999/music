<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tracks;
use frontend\models\TracksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\Images;
use frontend\models\Sounds;
use common\components\UploadedFile;
use common\components\Helpers;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * TracksController implements the CRUD actions for Tracks model.
 */
class TracksController extends Controller
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
     * Lists all Tracks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TracksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tracks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tracks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tracks();
        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $time = Date("Y-m-d H:i:s");
            $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
            $today = Date("Y-m-d");

            $model->created_user = $userid;
            $model->created_time = $time;
            $model->updated_user = $userid;
            $model->updated_time = $time;

            if ($model->save()) {
                $upload = new UploadedFile;
                //$img = $upload->UploadImage($model, 'cover', 'tracks');

                $track = $upload->UploadTracks($model, 'url', 'tracks');

                // add an event for user status
                $helpers = new Helpers;
                $event = $helpers->userEvent($model->id, 'track');

                if ($track) {
                    return $this->redirect(['albums/view', 'id' => $model->album_id]);
                    //return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
        }

        return $this->render('create', [
            'model' => $model,
            'image' => [],
            'track' => []
        ]);
    }

    /**
     * Updates an existing Tracks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $image = Images::find()->where(['source_id' => $id, 'user_id' => $userid])->orderBy('id DESC')->one();
        $track = Sounds::find()->where(['source_id' => $id, 'user_id' => $userid])->orderBy('id DESC')->one();
        if ($model->load(Yii::$app->request->post())){
            
            $post = Yii::$app->request->post();

            if(isset($post)){
                
                
                $upload = new UploadedFile;

                //delete cover image when a hidden input set to delete
                $c_action = isset($post['cover_action']) ? $post['cover_action'] : '';
                $t_action = isset($post['track_action']) ? $post['track_action'] : '';

                $img = $upload->UploadImage($model, 'cover', 'tracks', $c_action);

                $track = $upload->UploadTracks($model, 'url', 'tracks', $t_action);

            }
            
            $time = Date("Y-m-d H:i:s");
            $model->updated_user = $userid;
            $model->updated_time = $time;

            if ($model->save()) {
                return $this->redirect(['albums/view', 'id' => $model->album_id]);
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'image' => isset($image) ? $image : [],
            'track' => isset($track) ? $track : [],
        ]);
    }

    /**
     * Deletes an existing Tracks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (isset($model) && NULL != $model) {
            $model->active = 0;
            $model->save();
        }
        return $this->redirect(['albums/view', 'id' => $model->album_id]);
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Tracks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tracks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tracks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionGetTrackUrl()
    {
        $post = $_POST;

        if (isset($post)) {

            $weburl = Url::to("@web");
            $link = $post['url'];
            $id = explode('-', base64_decode(base64_decode($link)));
            $sound = Sounds::find()->where(['source_id' => $id[0]])->asArray()->one();
            
            if (isset($sound) && count($sound) > 0) {
                $result = $weburl . $sound['url']. $sound['filename'].'.'.$sound['ext'];
                echo json_encode('[{"result":1, "url":"'.$result.'"}]');
            } else {
                 echo json_encode('[{"result":0}]');
            }
        } else {
             echo json_encode('[{"result":0}]');
        }
    }
}
