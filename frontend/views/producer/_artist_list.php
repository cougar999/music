<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

//echo Html::a(Html::encode($model->album_name), ['view', 'id' => $model->id], ['class' => 'thumbnail']);
$imgfilename = 'Does not have a cover yet.';
$img_url = '/frontend/web/images/avatar_default2_400x400.jpg';

$ext = '';
if (isset($model->userPhoto)) {
	$image_model = $model->userPhoto;
	$imgfilename = $image_model->filename;
	$ext = $image_model->ext;
	$img_url = $image_model->url.$imgfilename.'.'.$ext;
}
//var_dump($model->userPhoto);
?>

<div class="col-xs-12 col-md-3 col-lg-3 mb-5">
	<div class="view overlay zoom">
		<img src="<?= Url::home() . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $model->username ?>" class="img-fluid z-depth-2">
		<div class="rgba-blue-light mask flex-center waves-effect waves-light">
			<h5>
				<a href="<?= Url::home() ?>site/artist-bio?artist_id=<?= $model->id ?>" target="_blank"><?= StringHelper::truncate($model->username, 40, '...', null, true) ?></a>
			
			</h5>
		</div>
	</div>
</div>

