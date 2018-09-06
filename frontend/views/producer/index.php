<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
use common\components\Helpers;
$helpers = new helpers;
$avatar = $helpers->getAvatar();

$this->title = $title;
$baseUrl = Url::base();

$profile = isset($artist['profile']) ? $artist['profile'] : [];
//var_dump($popSongsProvider->getModels());

?>
<div class="producer-index">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
            <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
        	<div class="row mb-3">
        		<div class="col-md-12 col-sm-12 col-lg-12 mb-3">
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
		                                 <?= isset($follow_number) && isset($follow_number->count)  ? $follow_number->count : 0 ?> Followers
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
        		<div class="col-md-8 col-sm-12 col-lg-8">

        			<!-- Classic tabs -->
					<div class="classic-tabs mb-4">

					<!-- Nav tabs -->
					<ul class="nav tabs-grey" role="tablist">
						<li class="nav-item active">
							<a class="nav-link waves-light" data-toggle="tab" href="#panel1" role="tab"><i class="fa fa-heart fa-2x" aria-hidden="true"></i>
                  <br>Popular Albums</a>
						</li>
						<li class="nav-item">
							<a class="nav-link waves-light" data-toggle="tab" href="#panel2" role="tab"><i class="fa fa-star fa-2x" aria-hidden="true"></i>
                  <br> Popular Artists</a>
						</li>
						<li class="nav-item">
							<a class="nav-link waves-light" data-toggle="tab" href="#panel3" role="tab"><i class="fas fa-music fa-2x" aria-hidden="true"></i>
                  <br> Popular Songs</a>
						</li>
					</ul>

					<div class="tab-content card rgba-white-strong">
						<div class="tab-pane active" id="panel1" role="tabpanel">
							<div class="row">
					            <?= ListView::widget([
					                'dataProvider' => $dataProvider,
					                'summary' => '',
					                'itemOptions' => [
					                    'class' => 'item'
					                ],
					                'itemView' => '_item_list',
					                'viewParams' => [
					                    'baseurl' => Url::home()
					                ],
					            ]) ?>
					        </div>
						</div>
						<div class="tab-pane " id="panel2" role="tabpanel">
							<div class="row">
					            <?= ListView::widget([
					                'dataProvider' => $welArtistProvider,
					                'summary' => '',
					                'itemOptions' => [
					                    'class' => 'item'
					                ],
					                'itemView' => '_artist_list',
					                'viewParams' => [
					                    'baseurl' => Url::home()
					                ],
					            ]) ?>
					        </div>
						</div>
						<div class="tab-pane" id="panel3" role="tabpanel">
							<div class="table-responsive mt15">
							<table class="table table-striped table-hover">
							    <tr>
							        <th>Name</th>
							        <th>Likes</th>
							        <th></th>
							    </tr>
					            <?= ListView::widget([
					                'dataProvider' => $popSongsProvider,
					                'summary' => '',
					                'itemOptions' => [
					                    'class' => 'item'
					                ],
					                'itemView' => '_track_list',
					                'viewParams' => [
					                    'baseurl' => Url::home(),
					                ],
					            ]) ?>
					        </table>
							</div>

						</div>
					</div>
					</div>

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
        		<div class="col-md-4 col-sm-12 col-lg-4">
					<div class="card rgba-white-strong">
		                <div class="card-body">
		                <h4 class="card-title text-dark"><a>Intros</a></h4>
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

        		</div>
        	</div>

        </div>
    </div>

    </div>


</div>
<?php 
$script1 = <<< JS

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
<?= $this->render('/layouts/_sharejs') ?>
<?= $this->render('/layouts/_player', ['userid' =>$userid]) ?>