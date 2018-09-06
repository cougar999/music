<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
$baseUrl = Url::base();

// meta keywords and descriptions
$this->title = $model->album_name;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->album_name.',',
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->album_description,
]);

// embed js for likes or follow
$this->registerJsFile($baseUrl.'/frontend/web/js/actions.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


if (isset($model->aImages[0]) && NULL != isset($model->aImages[0])) {
    $img = $model->aImages[0];
} else {
    $img = [];
    $img['url'] = '/frontend/web/images/';
    $img['filename'] = 'album_default';
    $img['ext'] = 'jpg';
}

//var_dump($like, $like_number);
?>
<div class="albums-view">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_producer_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-8">
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <!-- tracks -->
            <div class="track_list mt15">

                <div class="media clearfix">
                  <div class="media-left">
                  <img class="media-object img-thumbnail" src="<?= $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'] ?>" alt="<?= $model->album_name; ?>" width="350">
                  <!-- likes -->
                  <div class="mt10">
                    <?php if(isset($like) && $like->active == 1): ?>
                      <a class="btn btn-info like" href="#like" role="button" album-id="<?= $model->id ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like (<span class="count"><?= isset($like_number) && isset($like_number->count)  ? $like_number->count : 0 ?></span>)</a>
                    <?php else : ?>
                        <a class="btn btn-default like" href="#like" role="button" album-id="<?= $model->id ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like (<span class="count"><?= isset($like_number) && isset($like_number->count)  ? $like_number->count : 0 ?></span>)</a>
                    <?php endif; ?>
                  </div>
                  
                  </div>
                  <div class="media-body">
                    <h3 class="media-heading"><?= $model->album_name; ?></h3>
                    <dl class="dl-horizontal">
                        <dt>Artist:</dt>
                        <dd>
                            <?= isset($author) ? '<a href="artist-bio?artist_id='.$author['user']['id'].'" target="_blank">'.$author['user']['username'].'</a>' : 'Unknown'; ?>
                        </dd>
                        <dt>
                            Language:
                        </dt>
                        <dd>
                            <?= isset($language[$model->language]) ? $language[$model->language] : 'Unknown'; ?>
                        </dd>
                        <dt>
                            Type:
                        </dt>
                        <dd>
                            <?= $model->type == 1 ? 'Single' : 'Album'; ?>
                        </dd>
                        <dt>
                            First Release:
                        </dt>
                        <dd>
                            <?= $model->first_release_date; ?>
                        </dd>
                        <dt>
                            Created Time:
                        </dt>
                        <dd>
                            <?= $model->created_time; ?>
                        </dd>
                        <dt>
                            Genre:
                        </dt>
                        <dd>
                            <?php 
                                if (isset($genres) && NULL != $genres) {
                                    echo implode(', ', array_values($genres));
                                }
                            ?>
                        </dd>
                        <dt>
                            Description:
                        </dt>
                    </dl>
                    <p><br><span class="small"><?= $model->album_description ?></span></p>
                  </div>
                </div>

                <div class="table-responsive mt15">
                <table class="table table-striped">
                    <tr>
                        <th>Tracks In '<?= $model->album_name; ?>'</th>
                        <th></th>
                    </tr>
                    <?php if(isset($tracks)): ?>
                        <?php foreach($tracks as $key=> $value): ?>
                            <?php if(isset($value['allSounds']) && count($value['allSounds'])>0): ?>
                            <tr>
                                <td>
                                    #<?= $key+1 ?> <?= $value['name'] ?> - id:<?= $value['id'] ?>
                                </td>
                                <td class="text-right">
                                    <?php if(isset($value['allSounds']) && NULL != $value['allSounds']): ?>
                                    <?php foreach($value['allSounds'] as $sounds): ?>

                                        <a class="like_song <?= in_array($value['id'], array_keys($like_tracks)) ? 'text-info' : '' ?>" href="#likesong"  track-id="<?= $value['id'] ?>"><span class="glyphicon glyphicon-thumbs-up"></span></a> &nbsp;

                                        <a href="<?= base64_encode(base64_encode($value['id'].'-'.$value['name'])); ?>" title="<?= $value['name'] ?>" data-trackid="<?= $value['id']?>" target="_blank" class="addtolist"><span class="glyphicon glyphicon-plus"></span></a>  &nbsp;
                                        <a href="<?= base64_encode(base64_encode($value['id'].'-'.$value['name'])); ?>" title="<?= $value['name'] ?>" data-trackid="<?= $value['id']?>" target="_blank" class="songplaybtn"><span class="glyphicon glyphicon-play-circle"></span></a>  &nbsp;
                                        
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    
                    <?php endif; ?>
                    
                </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->render('/layouts/_player', ['userid' =>$userid]) ?>
