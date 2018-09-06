<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Playlist */

$this->title = Yii::t('app', 'Update Playlist: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Playlists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="playlist-update">
	<div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_common_left_menu') ?>
    </div>
    <div class="col-md-10 col-sm-12 col-lg-10">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>

</div>
