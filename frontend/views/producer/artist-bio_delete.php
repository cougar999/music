<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

$this->title = $artist['user']['username'] . "'s Bio";
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $artist['user']['username'] . "'s Bio",
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $artist['user']['username'] . "'s Bio and Albums.",
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = Url::base();
// embed js for likes or follow
//$this->registerJsFile($baseUrl.'/frontend/web/js/actions.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


if (isset($model->aImages[0]) && NULL != isset($model->aImages[0])) {
    $img = $model->aImages[0];
} else {
    $img = [];
    $img['url'] = '/frontend/web/images/';
    $img['filename'] = 'avatar_default2';
    $img['ext'] = 'jpg';
}
//var_dump($city, $country);die();
//var_dump($artist['profile']);
//var_dump($artist['user']['id']);die();
?>
<div class="artist-bio">

    <div class="row fans-index">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_producer_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-8">
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <!-- tracks -->
            <div class="track_list mt15">

                <div class="media clearfix">
                  <div class="media-left">
                  <img class="media-object img-thumbnail" src="<?= $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'] ?>" alt="<?= $artist['user']['username']; ?>" width="350">
                  <!-- follow -->
                  <div class="mt10">
                    <?php if(isset($follow) && $follow->active == 1): ?>
                      <a class="btn btn-info follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $artist['user']['id'] ?>"><span class="glyphicon glyphicon-heart"></span> Follow (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
                    <?php else : ?>
                        <a class="btn btn-default follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $artist['user']['id'] ?>"><span class="glyphicon glyphicon-heart-empty"></span> Follow (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
                    <?php endif; ?>
                  </div>
                  </div>
                  <div class="media-body">
                    <h3 class="media-heading"><?= $artist['user']['username']; ?></h3>
                    <dl class="dl-horizontal">
                        <dt>Location:</dt>
                        <dd><?= isset($artist['profile']['city']) ? $city[$artist['profile']['city']] : 'Unknown'; ?>, <?= isset($artist['profile']['country']) ? $country[$artist['profile']['country']] : 'Unknown'; ?></dd>
                        <dt>Gender:</dt>
                        <dd>
                            <?php
                            if ($artist['profile']['gender'] == 1) {
                                echo 'Male';
                             } elseif($artist['profile']['gender'] == 2) {
                                echo "Female";
                             } else {
                                echo "Prefer not to say";
                             }
                             ?>
                        </dd>
                        <dt>Joined Time:</dt>
                        <dd><?= date("Y-m-d", $artist['user']['created_at']); ?></dd>
                    </dl>
                  </div>
                </div>

                
            </div>

    
            <div>
                <h3><?= Html::encode('Albums') ?></h3>
            </div>
            <div class="row" id="album_list">
                
                <?php if(isset($albums)): ?>
                    <?php foreach($albums as $key=> $value): ?>
                        <div class="col-xs-12 col-md-4 col-lg-4">
                        <div class="thumbnail">
                            <?php
                            $imgfilename = 'Does not have a cover yet.';
                            $img_url = '/frontend/web/images/album_default.jpg';
                            $ext = '';
                            if (isset($value->aImages[0])) {
                                $image_model = $value->aImages[0];
                                $imgfilename = $image_model->filename;
                                $img_url = $image_model->url.$imgfilename.'_400x400.'.$ext;
                                $ext = $image_model->ext;
                            }
                            ?>
                            <a href="album-view?id=<?= $value->id ?>" target="_blank"><img src="<?= $baseUrl . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $value->album_name ?>"></a>
                            <div class="caption text">
                                <h5>
                                    <a href="album-view?id=<?= $value->id ?>" target="_blank"><?= StringHelper::truncate($value->album_name, 40, '...', null, true) ?></a>
                                
                                </h5>
                            </div>
                        </div>
                    </div>
                        
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<?= $this->render('/layouts/_player', ['userid' =>$userid]) ?>

<?php 
$script1 = <<< JS

$('.thumbnail').on('mouseover', function(event) {
    $(this).find('.text').show();
}); 
$('.thumbnail').on('mouseout', function(event) {
    $(this).find('.text').hide();
}); 

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>