<?php
use yii\helpers\Html;
use yii\helpers\Url;
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

<div class="col-xs-12 col-md-3 col-lg-3 mb-5">
	<div class="view overlay zoom">
		<a href="<?= Url::home() ?>site/album-view?id=<?= $model->id ?>" target="_blank"><img src="<?= Url::home() . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $model->album_name ?>" class="img-fluid z-depth-2"></a>
		<div class="rgba-blue-light mask flex-center waves-effect waves-light">
			<h5>
				<a href="<?= Url::home() ?>site/album-view?id=<?= $model->id ?>" target="_blank"><?= StringHelper::truncate($model->album_name, 40, '...', null, true) ?></a>
			
			</h5>
		</div>
	</div>
</div>

