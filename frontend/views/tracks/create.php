<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tracks */

$this->title = Yii::t('app', 'Upload Tracks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tracks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tracks-create">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
			<?= $this->render('/layouts/_artist_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-8">
			<h1><?= Html::encode($this->title) ?></h1>

		    <?= $this->render('_form', [
		        'model' => $model,
		        'image' => $image,
		        'track' => $track
		    ]) ?>
        </div>
	</div>

</div>
