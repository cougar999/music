<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PlaylistRelations */

$this->title = Yii::t('app', 'Create Playlist Relations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Playlist Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlist-relations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
