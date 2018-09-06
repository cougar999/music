<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;

$baseUrl = Url::base();
$weburl = Yii::getAlias('@web');

$this->title = 'You are Listening - '. $model->album_name;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->album_name.',',
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->album_description,
]);

$this->registerCssFile($weburl.'/frontend/web/lib/SoundManager/vert-player/css/bar-ui2.css?ver201807051', [], 'css-bar-ui2');
$this->registerJsFile($weburl.'/frontend/web/lib/SoundManager/script/soundmanager2-nodebug.js?ver201807051', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($weburl.'/frontend/web/lib/SoundManager/vert-player/script/bar-ui-single.js?ver201807051', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile($weburl.'/frontend/web/js/player-single.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


//var_dump($model);
if (isset($model->aImages[0]) && NULL != isset($model->aImages[0])) {
    $img = $model->aImages[0];
    //$image = $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'];
} else {
    $img = [];
    $img['url'] = '/frontend/web/images/';
    $img['filename'] = 'album_default';
    $img['ext'] = 'jpg';
}
$image = $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'];
?>

<?php if(isset($model) && $model != NULL): ?>

<div class="background-image"></div>

<div class="row" id="listen">
	<div class="col-lg-8 col-md-8">
		<div class="float-left">
		<h1><a href="<?= $baseUrl ?>/site/album-view?id=<?= $model->id ?>" target="_blank"><?= $model->album_name ?></a></h1>
		<h4 class="mb-5"><?= isset($author) ? '<a href="'.$baseUrl.'/site/artist-bio?artist_id='.$author['user']['id'].'" target="_blank">'.$author['user']['username'].' <i class="fas fa-external-link-alt fa-xs"></i> </a>' : 'Unknown'; ?> </h4>
		</div>

	<div class="sm2-bar-ui playlist-open full-width textured">

	<div class="bd sm2-main-controls">

		<div class="sm2-inline-texture"></div>
		<div class="sm2-inline-gradient"></div>

		<div class="sm2-inline-element sm2-button-element">
			<div class="sm2-button-bd">
				<a href="#play" class="sm2-inline-button sm2-icon-play-pause">Play / pause</a>
			</div>
		</div>

		<div class="sm2-inline-element sm2-inline-status">

			<div class="sm2-playlist">
				<div class="sm2-playlist-target">
				<!-- playlist <ul> + <li> markup will be injected here -->
				<!-- if you want default / non-JS content, you can put that here. -->
				<noscript><p>JavaScript is required.</p></noscript>
				</div>
			</div>

			<div class="sm2-progress">
				<div class="sm2-row">
					<div class="sm2-inline-time">0:00</div>
					<div class="sm2-progress-bd">
						<div class="sm2-progress-track">
							<div class="sm2-progress-bar"></div>
							<div class="sm2-progress-ball"><div class="icon-overlay"></div></div>
						</div>
					</div>
					<div class="sm2-inline-duration">0:00</div>
				</div>
			</div>

		</div>

		<div class="sm2-inline-element sm2-button-element sm2-volume">
			<div class="sm2-button-bd">
				<span class="sm2-inline-button sm2-volume-control volume-shade"></span>
				<a href="#volume" class="sm2-inline-button sm2-volume-control">volume</a>
			</div>
		</div>

		<div class="sm2-inline-element sm2-button-element">
			<div class="sm2-button-bd">
				<a href="#prev" title="Previous" class="sm2-inline-button sm2-icon-previous">&lt; previous</a>
			</div>
		</div>

		<div class="sm2-inline-element sm2-button-element">
			<div class="sm2-button-bd">
				<a href="#next" title="Next" class="sm2-inline-button sm2-icon-next">&gt; next</a>
			</div>
		</div>

		<div class="sm2-inline-element sm2-button-element sm2-menu">
			<div class="sm2-button-bd">
				<a href="#menu" class="sm2-inline-button sm2-icon-menu">menu</a>
			</div>
		</div>

	</div>

	<div class="bd sm2-playlist-drawer sm2-element" >

	<!-- <div class="sm2-inline-texture">
		<div class="sm2-box-shadow"></div>
	</div> -->

	<!-- playlist content is mirrored here -->

	<div class="sm2-playlist-wrapper">

		<ul class="sm2-playlist-bd">

		<?php if(isset($tracks)): ?>
			<?php foreach($tracks as $key=> $value): ?>
				
				<?php if(isset($value['allSounds']) && NULL != $value['allSounds']): ?>
					<li>
		        	<?php foreach($value['allSounds'] as $sounds): ?>
		        		<div class="sm2-row">
		        			<div class="sm2-col sm2-wide" style="width: 88%;">
		                		<a href="<?= base64_encode(base64_encode($value['id'].'-'.$value['name'])); ?>" title="<?= $value['name'] ?>" data-trackid="<?= $value['id']?>" target="_blank" class="songplaybtn"><?= $key+1 ?>. <?= $value['name'] ?></a> &nbsp;
		                	</div>
		                	<div class="sm2-col">
		                		<a class="like_song border-right border-light float-left <?= in_array($value['id'], $like_tracks) ? 'text-info' : '' ?>" href="#likesong"  track-id="<?= $value['id'] ?>"><span class="fas fa-thumbs-up"></span>
                                </a>
		                		<a href="#trackid" data-trackid="<?= $value['id'] ?>" class="song2playlist float-left"><i class="fas fa-plus"></i></a>
		                	</div>
		            	</div>
		        	<?php endforeach; ?>
		        	</li>
		        <?php else : ?>
				<?php endif; ?>
				
			<?php endforeach; ?>
		<?php endif; ?>

		</ul>

	</div>
	

	<div class="sm2-extra-controls">
		<div class="bd">
			<div class="sm2-inline-element sm2-button-element">
			<a href="#prev" title="Previous" class="sm2-inline-button sm2-icon-previous">&lt; previous</a>
			</div>

			<div class="sm2-inline-element sm2-button-element">
			<a href="#next" title="Next" class="sm2-inline-button sm2-icon-next">&gt; next</a>
			</div>
		</div>
	</div>



	</div>

	<div class="playlist_user mb-3 pt-2 pb-3 grey darken-4" id="user_playlist">
        <div class="row">
            <div class="col">
            <h3 class="d-inline ml-3 mt-3">Playlist <small><a title="Manage your playlists." href="<?= $weburl ?>/playlist"><i class="fas fa-cog"></i></a></small></h3>
            <ul class="nav nav-pills" id="playlist_list">

            	<?php if(isset($playlist)): ?>
					<?php foreach($playlist as $key=> $value): ?>
                		<li id="list-<?= $value->id ?>"><a href="#<?= $value->id ?>" title="<?= $value->name ?>" class="loadSongs" playlist="<?= $value->id ?>"><?= $value->name ?></a></li>
	                <?php endforeach; ?>
	            <?php else: ?>
	            	<li><a href="<?= $weburl ?>/playlist">Create a new playlist</a></li>
				<?php endif; ?>
            </ul>
            </div>
        </div>
    </div>
    <hr />

	</div>
		
	</div>
	<div class="col-lg-4 col-md-4">
		<div id="record_bg" class="">
			<div id="record_stylus" class="record_stylus"></div>
			<img class="img-fluid z-depth-1 rounded-circle " src="<?= $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'] ?>" alt="<?= $model->album_name; ?>" width="180">	
		</div>
		
	</div>
</div>

<div class="row">
	<div class="col-lg-8 col-md-8">
		<!-- likes -->
		<div class="mt10">
		<?php if(isset($like) && $like->active == 1): ?>
		  <a class="btn btn-info like" href="#like" role="button" source-id="<?= $model->id ?>" cate="album"><span class="fas fa-thumbs-up"></span> Like this Album (<span class="count"><?= isset($like_number) && isset($like_number->count)  ? $like_number->count : 0 ?></span>)</a>
		<?php else : ?>
		    <a class="btn btn-default like" href="#like" role="button" source-id="<?= $model->id ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like this Album (<span class="count"><?= isset($like_number) && isset($like_number->count)  ? $like_number->count : 0 ?></span>)</a>
		<?php endif; ?>

		<?php if(isset($follow) && $follow->active == 1): ?>
          <a class="btn btn-info follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $author['user']['id'] ?>"><span class="glyphicon glyphicon-heart"></span> Follow This Artist (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
        <?php else : ?>
            <a class="btn btn-default follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $author['user']['id'] ?>"><span class="glyphicon glyphicon-heart-empty"></span> Follow This Artist (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
        <?php endif; ?>

		<a class="btn btn-primary purple-gradient" href="listen"><i class="fas fa-sync-alt"></i> Roll</a>
		<a class="btn btn-primary purple-gradient" href="index?edit=1"><i class="fas fa-sliders-h"></i> Refine the Genres</a>

		</div>
	</div>
</div>

<div class="row mt-5" id="listen_content">
    <div class="col-md-2 col-sm-12 col-lg-2">
    	<?= $this->render('/layouts/_common_left_menu') ?>
    </div>
    <div class="col-md-10 col-sm-12 col-lg-10 list-view">
		<h2 class="mb-5">Related Albums</h2>
    	<?php if(isset($albums)): ?>
            <?php foreach($albums as $key=> $value): ?>
                <div class="col-xs-12 col-md-3 col-lg-3 mb-5">
					<?php
                    $imgfilename = 'Does not have a cover yet.';
                    $img_url = '/frontend/web/images/album_default.jpg';
                    $ext = '';
                    if (isset($value->aImages[0])) {
                        $image_model = $value->aImages[0];
                        $imgfilename = $image_model->filename;
                        $ext = $image_model->ext;
                        $img_url = $image_model->url.$imgfilename.'_400x400.'.$ext;
                        
                    }
                    ?>
					<div class="view overlay zoom">
						<a href="<?= Url::home() ?>site/album-view?id=<?= $value->id ?>"><img src="<?= Url::home() . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $value->album_name ?>" class="img-fluid z-depth-2"></a>
						<div class="rgba-blue-light mask flex-center waves-effect waves-light">
							<h5>
								<a href="<?= Url::home() ?>site/album-view?id=<?= $value->id ?>"><?= StringHelper::truncate($value->album_name, 40, '...', null, true) ?></a>
							
							</h5>
						</div>
					</div>
            	</div>
                
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>

	<h1 class="mb-5 mt-5 text-center">Sorry, we do not have any Recommendations for you, please refine your Genres.</h1>
	<div class="row text-center mb-5">
		<a class="btn btn-primary purple-gradient" href="index?edit=1">Refine the Genres</a>
	</div>

<?php endif; ?>

<?= $this->render('/layouts/_playlist', ['userid' =>$userid]) ?>

<style>
body {
	background:none;
}
.background-image {
  background-image: url('<?= isset($image) ? $image : '' ?>');
  background-size: cover;
  display: block;
  filter: blur(12px);
  -webkit-filter: blur(12px);
  height: 100%;
  left: 0;
  position: fixed;
  right: 0;
  z-index: -1;
}
</style>

<?php 
$script1 = <<< JS
// $(document).ready(function(){


// });
JS;
$this->registerJs($script1, \yii\web\View::POS_END);
?>
