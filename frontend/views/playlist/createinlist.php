<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Playlist */

$this->title = Yii::t('app', 'Create Playlist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Playlists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    html, body {
        background: none;
        color: #333;
    }
</style>
<div class="playlist-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
