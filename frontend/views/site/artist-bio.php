<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
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

if (isset($artist_bio->userPhoto) && NULL != isset($artist_bio->userPhoto)) {
    $img = $artist_bio->userPhoto;
} else {
    $img = [];
    $img['url'] = '/frontend/web/images/';
    $img['filename'] = 'avatar_default2';
    $img['ext'] = 'jpg';
}

$profile = isset($artist['profile']) ? $artist['profile'] : [];
$avatar = $baseUrl.$img['url'].$img['filename'].'.'.$img['ext'];

//var_dump($like, $like_number);
?>
<?php Pjax::begin(); ?>
<div class="artist-bio">

    <div class="row fans-index">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
        <!-- Section: bio v.4 -->
        <section class="bio-background">

          <!-- Grid row -->
          <div class="row">

            <!-- Grid column -->
            <div class="col-lg-12 col-md-12">
              <div class="card-wrapper">
                <div id="card-3" class="card-rotating effect__click w-100 h-100">
                  <!-- Front Side -->
                  <div class="face front">
                    <!-- Image -->
                    <div class="card-up">
                      <img class="card-img-top" src="/music/frontend/web/images/concert.jpg" alt="background">
                    </div>
                    <!-- Avatar -->
                    <div class="media bio-info">
                        <img class="d-flex mr-3 rounded-circle" width="140" src="<?= $avatar ?>" alt="Generic placeholder image">
                        <div class="media-body">
                            <div class="clearfix">
                            <h3 class="font-weight-bold text-shadow mt-5 mb-5 float-left"><?= $artist['user']['username'] ?></h3>
                            <div class="float-right mt-5">
                                <?php if(isset($follow) && $follow->active == 1): ?>
                                  <a class="btn btn-info follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $artist['user']['id'] ?>"><span class="glyphicon glyphicon-heart"></span> Follow (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
                                <?php else : ?>
                                    <a class="btn btn-default follow" href="#Follow" role="button" followers="<?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?>" artist-id="<?= $artist['user']['id'] ?>"><span class="glyphicon glyphicon-heart-empty"></span> Follow (<span class="count"><?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?></span>)</a>
                                <?php endif; ?>

                            </div>
                            </div>
                            <div class="clearfix mt-2">
                                <?= $artist['profile']['bio'] ?>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Grid column -->

          </div>
          <!-- Grid row -->

        </section>

        <!-- Section: Social newsfeed v.1 -->
                <section class="my-3">

                  <!-- Grid row -->
                  <div class="row">
            
                    <!-- Grid column -->
                    <div class="col-md-8 col-sm-12 col-lg-8">

                      <!-- Newsfeed -->
                      <div class="mdb-feed list-view">
                        <?php if(isset($contents)): ?>
                            
                            <?php foreach($contents as $key=> $value): ?>
                                <div class="news rounded">

                                    <div class="label">
                                        <img src="<?= $avatar ?>" class="rounded-circle z-depth-1-half">
                                    </div>

                                    <div class="excerpt">

                                        <?php if(isset($contents[$key]) && $contents[$key]['type'] == 'album'): ?>

                                            <div class="brief">
                                                <a class="name"><?= $artist['user']['username'] ?></a> added an album
                                                <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                            </div>
                                            <?php $images[$key] = isset($contents[$key]['related']['aImages'][0]) ? $contents[$key]['related']['aImages'][0] : []; ?>
                                            <div class="added-images">
                                                
                                                <div class="media">
                                                <a href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['source_id']; ?>">
                                                <?php if (isset($images[$key]) && count($images[$key])>0): ?>
                                                     <img src="<?= $baseUrl . $images[$key]['url'] . $images[$key]['filename'] . '_400x400.'. $images[$key]['ext'] ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                <?php else: ?>
                                                    <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                <?php endif ?>
                                                </a>
                                                <div class="media-body">
                                                    <h4><a class="text-dark" href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['source_id']; ?>"><?= $contents[$key]['related']['album_name'] ?></a></h4>
                                                    <?= StringHelper::truncate($contents[$key]['related']['album_description'], 40, '...', null, true) ?>
                                                </div>
                                                </div>
                                            </div>

                                        <?php elseif(isset($contents[$key]) && $contents[$key]['type'] == 'track'): ?>

                                            <div class="brief">
                                            <a class="name"><?= $artist['user']['username'] ?></a> added a song
                                            <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                            </div>

                                            <div class="added-images">
                                                <div class="media">
                                                <a href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['album_id']; ?>">
                                                    <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                </a>
                                                <div class="media-body">
                                                    <h4><a class="text-dark" href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['album_id']; ?>"><?= $contents[$key]['related']['name'] ?></a></h4>
                                                </div>
                                                </div>
                                            </div>

                                        <?php elseif(isset($contents[$key]) && $contents[$key]['type'] == 'like'): ?>

                                            
                                            <?php if ($contents[$key]['liketype'] == 'album'): ?>
                                                
                                                <div class="brief">
                                                <a class="name"><?= $artist['user']['username'] ?></a> liked an album
                                                <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                                </div>

                                                <?php $images[$key] = $contents[$key]['related']['aImages'][0]; ?>
                                                <div class="added-images">
                                                    
                                                    <div class="media">
                                                    <a href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['id']; ?>">
                                                    <?php if (isset($images[$key])): ?>
                                                         <img src="<?= $baseUrl . $images[$key]['url'] . $images[$key]['filename'] . '_400x400.'. $images[$key]['ext'] ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                    <?php else: ?>
                                                        <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                    <?php endif ?>
                                                    </a>
                                                    <div class="media-body">
                                                        <h4><a class="text-dark" href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['id']; ?>"><?= $contents[$key]['related']['album_name'] ?></a></h4>
                                                        <?= StringHelper::truncate($contents[$key]['related']['album_description'], 40, '...', null, true) ?>
                                                    </div>
                                                    </div>
                                                </div>

                                            <?php elseif($contents[$key]['liketype'] == 'track'): ?>

                                                <div class="brief">
                                                <a class="name"><?= $artist['user']['username'] ?></a> liked an track
                                                <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                                </div>
                                                <div class="added-images">
                                                    <div class="media">
                                                    <a href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['album_id']; ?>">
                                                        <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                    </a>
                                                    <div class="media-body">
                                                        <h4><a class="text-dark" href="<?= $baseUrl . '/site/album-view?id='.$contents[$key]['related']['album_id']; ?>"><?= $contents[$key]['related']['name'] ?></a></h4>
                                                    </div>
                                                    </div>
                                                </div>

                                            <?php endif ?>

                                        <?php elseif(isset($contents[$key]) && $contents[$key]['type'] == 'follow'): ?>

                                            <div class="brief">
                                                <a class="name"><?= $artist['user']['username'] ?></a> followed <a href="<?= $baseUrl.'/site/artist-bio?artist_id='.$contents[$key]['related']['userProfile']['id'] ?>"><?= $contents[$key]['related']['userProfile']['username'] ?></a>
                                                <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                            </div>

                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="feed-footer">
                                        <a class="like">
                                        <i class="fa fa-heart"></i>
                                        <span>5 likes</span>
                                        </a>
                                    </div> -->

                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <!-- Newsfeed -->

                  </div>
                    <!-- Grid row -->
                    <div class="col-md-4 col-sm-12 col-lg-4">
                        <div class="card rgba-white-strong">

                            <!-- Card content -->
                            <div class="card-body">

                            <!-- Title -->
                            <h4 class="card-title text-dark"><a>Intros</a></h4>
                            <!-- Text -->
                            <p class="card-text">Location: <?= isset($profile['city']) ? $city[$profile['city']] : 'Unknown'; ?>, <?= isset($profile['country']) ? $country[$profile['country']] : 'Unknown'; ?></p>
                            <p class="card-text">Gender: 
                            <?php
                            if (isset($profile['gender']) && $profile['gender'] == 1) {
                            echo 'Male';
                            } elseif(isset($profile['gender']) && $profile['gender'] == 2) {
                            echo "Female";
                            } else {
                            echo "Prefer not to say";
                            }
                            ?>
                            </p>
                            <p class="card-text">Joined Time: <?= date("d-M-Y", $artist['user']['created_at']); ?></p>

                            </div>

                        </div>

                        <div class="card rgba-white-strong my-4">
                            <div class="card-body">
                                <h4 class="card-title text-dark"><a>Social</a></h4>
                                <div class="card-text">
                                    <?php if(isset($profile['facebook']) && $profile['facebook'] != ''): ?>
                                        <a href="<?= $profile['facebook'] ?>" target="_blank" class="btn-sm btn-floating indigo darken-2 waves-effect waves-light"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                    <?php if(isset($profile['twitter']) && $profile['twitter'] != ''): ?>
                                        <a href="<?= $profile['twitter'] ?>" target="_blank" class="btn-sm btn-floating blue darken-1 waves-effect waves-light"><i class="fab fa-twitter "></i></a>
                                    <?php endif; ?>
                                    <?php if(isset($profile['youtube']) && $profile['youtube'] != ''): ?>
                                        <a href="<?= $profile['youtube'] ?>" target="_blank" class="btn-sm btn-floating red accent-4 waves-effect waves-light"><i class="fab fa-youtube "></i></a>
                                    <?php endif; ?>
                                    <?php if(isset($profile['linkedin']) && $profile['linkedin'] != ''): ?>
                                        <a href="<?= $profile['linkedin'] ?>" target="_blank" class="btn-sm btn-floating cyan darken-1 waves-effect waves-light"><i class="fab fa-linkedin-in"></i></a>
                                    <?php endif; ?>
                                    <?php if(isset($profile['instagram']) && $profile['instagram'] != ''): ?>
                                        <a href="<?= $profile['instagram'] ?>" target="_blank" class="btn-sm btn-floating deep-orange darken-3 waves-effect waves-light"><i class="fab fa-instagram"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="card rgba-white-strong my-4">

                        <!-- Card content -->
                            <div class="card-body">
                                <h4 class="card-title text-dark"><a>Albums</a></h4>
                                <div class="card-text">
                                    <?php if(isset($albums)): ?>
                                        <?php foreach($albums as $key=> $value): ?>
                                            <div class="col-xs-12 col-md-6 col-lg-6 p-1">
                                            <div class="overlay view zoom">
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
                                                <a href="album-view?id=<?= $value->id ?>" target="_blank"><img src="<?= $baseUrl . $img_url ?>" alt="<?= $imgfilename ?>" title="<?= $value->album_name ?>" class="img-fluid"></a>
                                                <div class="rgba-blue-light mask flex-center waves-effect waves-light">
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


                    </div>


                </section>
                <!-- Section: Social newsfeed v.1 -->

        </div>
    </div>

</div>
<?php Pjax::end(); ?>
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