<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
$this->title = Yii::t('app', 'Create Albums');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-create">
	
	<div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
		<?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-8">
			<h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'language' => $language,
		        'image' => isset($image) ? $image : [],
		        'genre' => $genre
		    ]) ?>
        </div>
	</div>

</div>
