<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tracks */

$this->title = Yii::t('app', 'Update Tracks: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tracks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tracks-update">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
		<?= $this->render('/layouts/_artist_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
			<h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'image' => isset($image) ? $image : [],
		        'track' => isset($track) ? $track : [],
		    ]) ?>
        </div>
	</div>

</div>
