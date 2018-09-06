<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;

//echo Html::a(Html::encode($model->album_name), ['view', 'id' => $model->id], ['class' => 'thumbnail']);

$imgfilename = 'Does not have a cover yet.';
$img_url = '/frontend/web/images/album_default.jpg';
$ext = '';
if (isset($model->userPhoto)) {
	$image_model = $model->userPhoto;
	$imgfilename = $image_model->filename;
	$ext = $image_model->ext;
	$img_url = $image_model->url.$imgfilename.'.'.$ext;
}
?>

<div class="col-xs-12 col-md-3 col-lg-3">
	<div class="view overlay zoom">
		<a href="artist-bio?artist_id=<?= $model->source_id ?>" target="_blank"><img src="<?= $baseurl . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $model->userProfile['username'] ?>" class="img-fluid z-depth-2"></a><span class="badge badge-primary sticky-top" style="right: 0;top: 0; position: absolute;"><?= $model->albumsCount ?> albums</span>
		<div class="rgba-blue-light mask flex-center waves-effect waves-light">
			<h5>
				<a href="artist-bio?artist_id=<?= $model->source_id ?>" target="_blank"><?= StringHelper::truncate($model->userProfile['username'], 40, '...', null, true) ?></a>
			
			</h5>
		</div>
	</div>
</div>
