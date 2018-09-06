<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\StringHelper;

//echo Html::a(Html::encode($model->album_name), ['view', 'id' => $model->id], ['class' => 'thumbnail']);

$imgfilename = 'Does not have a cover yet.';
$img_url = '/frontend/web/images/album_default.jpg';
$ext = '';
if (isset($model->aImages[0])) {
	$image_model = $model->aImages[0];
	$imgfilename = $image_model->filename;
	$ext = $image_model->ext;
	$img_url = $image_model->url.$imgfilename.'_400x400.'.$ext;
}
?>

<!-- Grid column -->
<div class="col-lg-3 col-md-12 mb-lg-0 mb-4">
	<!--Featured image-->
	<div class="view overlay rounded zoom z-depth-1">
		<img src="<?= $baseurl . $img_url ?>" class="img-fluid" alt="<?= $imgfilename ?>" title="<?= $model->album_name ?>">
		<a href="<?= Url::home() ?>site/album-view?id=<?= $model->id ?>">
		<div class="mask rgba-white-slight"></div>
		</a>
	</div>
	<!--Excerpt-->
	<div class="card-body pb-0">
		<h4 class="font-weight-bold my-3"><a href="<?= Url::home() ?>site/album-view?id=<?= $model->id ?>"><?= $model->album_name ?></a></h4>
		<p class="grey-text"><?= $model->album_description ?>
		</p>
		<a class="btn btn-indigo" href="<?= Url::home() ?>site/album-view?id=<?= $model->id ?>"><i class="fa fa-clone left"></i> View Album</a>
	</div>
</div>
<!-- Grid column -->

