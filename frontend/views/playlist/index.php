<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$baseUrl = Url::base();

$this->title = Yii::t('app', 'Playlists');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="playlist-index">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
            <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php Pjax::begin(); ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            
            <div class="row">
                <table class="table table-hover">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th width="50%">Playlist Name</th>
                            <th>Note</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->
                    <tbody>
                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => function ($model, $key, $index, $widget) {
                                $num = $index + 1;
                                $html = '<tr>';
                                $html .= '<th scope="row">'.$num .'</th>';
                                $html .= '<td>'.Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'd-block']).'</td>';
                                $html .= '<td>'.$model->note.'</td>';
                                $html .= '<td><a href="update?id='.$model->id.'" title="Update"><i class="fas fa-pencil-alt"></i></a> &nbsp; <a href="delete?id='.$model->id.'" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"><i class="fas fa-trash-alt"></i></a></td>';
                                $html .= '</tr>';

                                return $html; //Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'viewParams' => [
                                'baseurl' => Url::home()
                            ],
                        ]) ?>
                    </tbody>
                    <!--Table body-->

                </table>
            
            </div>
            <?php Pjax::end(); ?>
        </div>
</div>
</div>