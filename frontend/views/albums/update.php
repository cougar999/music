<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */

$this->title = Yii::t('app', 'Update Albums: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="albums-update">

	<div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
		<?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
			<h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'language' => $language,
		        'image' => $image,
		        'genre' => $genre,
		    ]) ?>
        </div>
	</div>

</div>
