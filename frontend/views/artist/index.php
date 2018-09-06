<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
use common\components\Helpers;
$helpers = new helpers;
$avatar = $helpers->getAvatar();
$baseUrl = Url::to("@web");
$this->title = $user->username . "'s homepage";
$profile = isset($artist['profile']) ? $artist['profile'] : [];
// var_dump($contents);
?>
<div class="artist">

    <div class="body-content">

        <div class="row">
            <div class="col-md-2 col-sm-12 col-lg-2">
                <div id="left-side-menu">
                <div class="sticky">
                    <div class="mb-3 border border-dark rounded p-2">
                            <img id="" width="30" height="30" src="<?= $avatar ?>" class="rounded-circle">    
                            <a href="<?= $baseUrl ?>/user/settings/profile" title="update profile"><?= $user->username ?></a>
                    </div>
    				<?= $this->render('/layouts/_common_left_menu') ?>
                </div>
                </div>
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
                              <img class="card-img-top" src="/music/frontend/web/images/banner1.jpg" alt="background">
                            </div>
                            <!-- Avatar -->
                            <div class="media bio-info">
                                <img class="d-flex mr-3 rounded-circle" width="140" src="<?= $avatar ?>" alt="Generic placeholder image">
                                <div class="media-body">
                                    <div class="clearfix">
                                    <h3 class="font-weight-bold text-shadow mt-5 mb-5 float-left"><?= $user->username ?></h3>
                                    <div class="float-right mt-5">
                                          <?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?> Followers
                                    </div>
                                    </div>
                                    <div class="clearfix mt-2">
                                        <?= StringHelper::truncate($artist['profile']['bio'], 150, '...', null, true) ?>  
                                        <a href="<?= $baseUrl . '/user/settings/profile'?>" class="blue-text"><i class="fas fa-cog"></i></a>
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
            

            <div class="row">
            <div class="col-md-8 col-sm-12 col-lg-8">
			    <div class="mt-5">
                    <h2>What's sound on your mind today?</h2>
                </div>
                <div class="">

                    <div class="card-deck">
                        <div class="card rgba-stylish-strong">
                            <a class="btn blue-gradient btn-lg" href="<?= $baseUrl ?>/albums/create">Create an Album</a>
                        </div>
                        <div class="card rgba-stylish-strong">
                            <a class="btn purple-gradient btn-lg" href="<?= $baseUrl ?>/albums/index">Manage Albums</a>
                        </div>
                        <!-- <div class="card rgba-stylish-strong">
                            <a class="btn aqua-gradient btn-lg" href="<?= $baseUrl ?>/site/message">Read Messages</a>
                        </div> -->
                    </div>

                </div>

                <!-- Section: Social newsfeed v.1 -->
                <section class="my-4">

                  <!-- Grid row -->
                  <div class="">

                    <!-- Grid column -->

                      <!-- Newsfeed -->
                      <div class="mdb-feed">



                        <?php if(isset($contents)): ?>
                            
                            <?php foreach($contents as $key=> $value): ?>
                                <div class="news rounded">

                                    <div class="label">
                                        <img src="<?= $avatar ?>" class="rounded-circle z-depth-1-half">
                                    </div>

                                    <div class="excerpt">

                                        <?php if(isset($contents[$key]) && $contents[$key]['type'] == 'album'): ?>

                                            <div class="brief">
                                                <a class="name"><?= $user->username ?></a> added an album
                                                <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                            </div>
                                            <?php $images[$key] = $contents[$key]['related']['aImages'][0]; ?>
                                            <div class="added-images">
                                                
                                                <div class="media">
                                                <a href="<?= $baseUrl . '/albums/view?id='.$contents[$key]['source_id']; ?>">
                                                <?php if (isset($images[$key])): ?>
                                                     <img src="<?= $baseUrl . $images[$key]['url'] . $images[$key]['filename'] . '_400x400.'. $images[$key]['ext'] ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                <?php else: ?>
                                                    <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                <?php endif ?>
                                                </a>
                                                <div class="media-body">
                                                    <h4><a class="text-dark" href="<?= $baseUrl . '/albums/view?id='.$contents[$key]['source_id']; ?>"><?= $contents[$key]['related']['album_name'] ?></a></h4>
                                                    <?= StringHelper::truncate($contents[$key]['related']['album_description'], 40, '...', null, true) ?>
                                                </div>
                                                </div>
                                            </div>

                                        <?php elseif(isset($contents[$key]) && $contents[$key]['type'] == 'track'): ?>

                                            <div class="brief">
                                            <a class="name"><?= $user->username ?></a> added a song
                                            <div class="date"><?=  date("d-M-Y h:m:s", strtotime($contents[$key]['created_time'])); ?></div>
                                            </div>

                                            <div class="added-images">
                                                <div class="media">
                                                <a href="<?= $baseUrl . '/albums/view?id='.$contents[$key]['related']['album_id']; ?>">
                                                    <img src="<?= $baseUrl . '/frontend/web/images/album_default_400x400.jpg'; ?>" class="z-depth-1 rounded mb-md-0 mb-2 d-flex mr-3">
                                                </a>
                                                <div class="media-body">
                                                    <h4><a class="text-dark" href="<?= $baseUrl . '/albums/view?id='.$contents[$key]['related']['album_id']; ?>"><?= $contents[$key]['related']['name'] ?></a></h4>
                                                </div>
                                                </div>
                                            </div>

                                        <?php elseif(isset($contents[$key]) && $contents[$key]['type'] == 'like'): ?>

                                            
                                            <?php if ($contents[$key]['liketype'] == 'album'): ?>
                                                
                                                <div class="brief">
                                                <a class="name"><?= $user->username ?></a> liked an album
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
                                                <a class="name"><?= $user->username ?></a> liked an track
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
                                                <a class="name"><?= $user->username ?></a> followed <a href="<?= $baseUrl.'/site/artist-bio?artist_id='.$contents[$key]['related']['userProfile']['id'] ?>"><?= $contents[$key]['related']['userProfile']['username'] ?></a>
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

                </section>
                <!-- Section: Social newsfeed v.1 -->

                <div class=" mt-5 mb-5 view">
                    <a href="<?= $baseUrl ?>/starter/index"><img class="img-fluid" src="<?= $baseUrl.Yii::$app->params['resurl'].'/images/banner2.jpg' ?>"></a>
                </div>


                <div class=" mt-5 mb-5">
                    <a class="btn btn-blue-grey btn-lg btn-block" href="<?= $baseUrl ?>/starter/index">I Feel Lucky.</a>
                </div>
                
            </div>
            <div class="col-md-4 col-sm-12 col-lg-4 mt-5">
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
                    <div class="clearfix">
                        <h4 class="card-title text-dark float-left"><a>Social</a></h4>
                        <a href="<?= $baseUrl.'/user/settings/social' ?>" class="float-right blue-text"><i class="fas fa-cog"></i></a>
                    </div>
                    
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
                    <div class="clearfix">
                        <h4 class="card-title text-dark float-left"><a>Albums</a></h4>
                        <a href="<?= $baseUrl.'/albums/index' ?>" class="float-right blue-text"><i class="fas fa-cog"></i></a>
                    </div>
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
            </div>
        </div>

    </div>
    
    

</div>
