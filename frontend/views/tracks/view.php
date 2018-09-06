<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tracks */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tracks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tracks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'album_id',
            'cover:ntext',
            'url:ntext',
            'artist_id',
            'lyricist',
            'composer',
            'arrangement',
            'lyrics:ntext',
            'active',
            'created_time',
            'updated_time',
            'created_user',
            'updated_user',
        ],
    ]) ?>

</div>
