<?php
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

<div class="col-xs-12 col-md-3 col-lg-3">
	<div class="view zoom thumbnail">
		<a href="view?id=<?= $model->id ?>"><img src="<?= $baseurl . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $model->album_name ?>" class="img-fluid"></a>
		<div class="caption text mt-2">
			<h4>
				<a href="view?id=<?= $model->id ?>" ><?= StringHelper::truncate($model->album_name, 40, '...', null, true) ?></a>
			</h4>
			<p class="small"><?= StringHelper::truncate($model->album_description, 150, '...', null, true) ?></p>
		</div>
	</div>
</div>

