<?php
use yii\helpers\Url;
// use yii\helpers\BaseUrl;
// $baseUrl = Url::base();

use yii\widgets\ListView;
$baseUrl = Yii::getAlias('@web');

use yii\widgets\Pjax;
/* @var $this yii\web\View */
if (isset(Yii::$app->user->identity) && NULL != Yii::$app->user->identity) {
    $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
} else{
    $userid = 0;
}

$this->title = Yii::$app->name;

?>
<header>

<!-- Intro Section -->
<div id="home" class="view jarallax h-100" data-jarallax='{"speed": 0.2}' style="background-image: url('<?= $baseUrl."/frontend/web/images/concert.jpg" ?>');">
    <div class="full-bg-img">
        <div class="mask rgba-black-strong">
            <div class="container flex-center">
                <div class="row smooth-scroll">
                    <div class="col-md-12">
                        <div class="text-center text-white">
                            <div class="wow fadeInDown" data-wow-delay=".2s">
                                <h1 class="font-weight-bold display-3 mb-0">Massive Exclusive Opportunities</h1>
                                <hr class="hr-light my-3">
                                <h4 class="pt-2 pb-3">What makes us different? We put your name in front of the decision makers.
                                    </h4>
                            </div>
                            <a class="btn btn-pink-blue btn-rounded wow fadeInUp" data-wow-delay=".2s" href="<?= $baseUrl ?>/user/registration/register" data-offset="100">
                                <i class="fas fa-rocket"></i>
                                <span>Start the Journey NOW</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</header>
<main style="overflow: hidden;">

<!--Section: Features v.1-->
<section class="container text-center mt-5 pb-lg-5 pt-lg-5">

    <!--Section heading-->
    <h1 class="py-5 font-weight-bold">We are the future</h1>
    <!--Section description-->
    <div class="md-row wow fadeInDown" data-wow-delay=".2s">
    <p class="px-5 mb-5 pb-3 lead text-center w-100">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
    aliqua. Ut enim ad minim veniam.</p>
    </div>
    <!--Grid row-->
    <div class="row">
    <!--Grid column-->
    <div class="col-md-4 wow fadeInDown" data-wow-delay=".2s">
        <i class="fa fa-music fa-3x red-text"></i>
        <h5 class="font-weight-bold mt-3">Artists</h5>
        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti
        hic.
        </p>
    </div>
    <!--Grid column-->

    <!--Grid column-->
    <div class="col-md-4 wow fadeInDown" data-wow-delay=".2s">
        <i class="fa fa-headphones fa-3x cyan-text"></i>
        <h5 class="font-weight-bold mt-3">Fans</h5>
        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti
        hic.
        </p>
    </div>
    <!--Grid column-->

    <!--Grid column-->
    <div class="col-md-4 wow fadeInDown" data-wow-delay=".2s">
        <i class="fa fa-volume-up fa-3x orange-text"></i>
        <h5 class="font-weight-bold mt-3">Producers</h5>
        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit maiores nam, aperiam minima assumenda deleniti
        hic.
        </p>
    </div>
    <!--Grid column-->

    </div>
    <!--Grid row-->

</section>
<!--Section: Features v.1-->

<!-- Projects section v.1 -->
<section class="container pt-5 mt-3 pb-3 text-center my-5">

  <!-- Section heading -->
  <h1 class="h2-responsive font-weight-bold my-5">Latest Albums</h1>
  <!-- Section description -->
  <!-- <p class="grey-text w-responsive mx-auto mb-5">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit est laborum.</p> -->

  <!-- Grid row -->
  <div class="row text-center">

    <?= ListView::widget([
        'dataProvider' => $latest_albums,
        'itemOptions' => [
            'class' => 'item'
        ],
        'itemView' => '_albums_list_index',
        'viewParams' => [
            'baseurl' => Url::home()
        ],
        'summary' => false,
    ]) ?>

  </div>
  <!-- Grid row -->

</section>
<!-- Projects section v.1 -->
            
<!--Section: Group of personal cards-->
<section class="container pt-5 mt-3 pb-3">

    <!--Section heading-->
    <h1 class="py-5 font-weight-bold text-center">Our Stars</h1>
    
    <!--Grid row-->
    <div class="row">

        <!--Grid column-->
        <div class="col-md-12">

            <!--Card group-->
            <div class="card-group">

                <!--Card-->
                <div class="card card-personal mb-3">

                    <!--Card image-->
                    <div class="view overlay">
                        <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(26).jpg" alt="Card image cap">
                        <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <!--Card image-->

                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <a><h4 class="card-title black-text">Anna</h4></a>
                        <!--Text-->
                        <p class="card-text">Anna is a Rock music lover.</p>
                        <hr>
                        <a class="card-meta"><span><i class="fa fa-user"></i>83 Friends</span></a>
                        <p class="card-meta float-right">Joined in 2012</p>
                    </div>
                    <!--Card content-->

                </div>
                <!--Card-->

                <!--Card-->
                <div class="card card-personal mb-3">

                    <!--Card image-->
                    <div class="view overlay">
                        <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(27).jpg" alt="Card image cap">
                        <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <!--Card image-->

                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <a><h4 class="card-title black-text">John</h4></a>
                        <!--Text-->
                        <p class="card-text">John is an artist was born in Europe.</p>
                        <hr>
                        <a class="card-meta"><span><i class="fa fa-user"></i>48 Friends</span></a>
                        <p class="card-meta float-right">Joined in 2015</p>
                    </div>
                    <!--Card content-->

                </div>
                <!--Card-->

                <!--Card-->
                <div class="card card-personal mb-3">

                    <!--Card image-->
                    <div class="view overlay">
                        <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(28).jpg" alt="Card image cap">
                        <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <!--Card image-->

                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <a><h4 class="card-title black-text">Sara</h4></a>
                        <!--Text-->
                        <p class="card-text">Sara is a video maker living in Tokyo.</p>
                        <hr>
                        <a class="card-meta"><span><i class="fa fa-user"></i>127 Friends</span></a>
                        <p class="card-meta float-right">Joined in 2014</p>
                    </div>
                    <!--Card content-->

                </div>
                <!--Card-->

                <!--Card-->
                <div class="card card-personal mb-3">

                    <!--Card image-->
                    <div class="view overlay">
                        <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(27).jpg" alt="Card image cap">
                        <a href="#!">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <!--Card image-->

                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <a><h4 class="card-title black-text">John</h4></a>
                        <!--Text-->
                        <p class="card-text">John is a Lyricist.</p>
                        <hr>
                        <a class="card-meta"><span><i class="fa fa-user"></i>48 Friends</span></a>
                        <p class="card-meta float-right">Joined in 2015</p>
                    </div>
                    <!--Card content-->

                </div>
                <!--Card-->

            </div>
            <!--Card group-->

        </div>
        <!--Grid column-->

    </div>
    <!--Grid row-->

</section>
<!--Section: Group of personal cards-->


<div class="row text-center mt20 mb-5">
    <a href="<?= Yii::$app->homeUrl ?>user/registration/register" type="button" class="btn purple-gradient btn-lg">Join as Artist, Fan or Producer for Free</a>
</div>

</main>
            


<?php 
$script1 = <<< JS

// $(window).on('load', function(event) {
//     $('.container').css({'width':'100%', 'height':'100%', 'padding':0, 'margin':0});
// }); 

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
