<?php

/**
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
/* @var $this yii\web\View */
$baseUrl = Url::to("@web");

$this->title = $title;
?>

<?php // $this->render('/_alert', ['module' => $module]); ?>
<div class="row">

    <div class="card-deck">
        <div class="card rgba-stylish-strong">
            <div class="card-body">
                <h4 class="card-title white-text">Tour</h4>
            </div>
            <!-- <div class="card-footer">
                <small class="white-text"> &gt;&gt; </small>
            </div> -->
            <a class="btn aqua-gradient btn-lg" href="<?= $baseUrl ?>/starter/index">Take a Tour</a>
        </div>
        <div class="card rgba-stylish-strong">
            <div class="card-body">
                <h4 class="card-title white-text">Profiles</h4>
            </div>
            <!-- <div class="card-footer">
                <small class="white-text">Last updated 3 mins ago</small>
            </div> -->
            <a class="btn purple-gradient btn-lg" href="<?= $baseUrl ?>/user/settings/profile">Update Your Profile</a>
        </div>
        <div class="card rgba-stylish-strong">
            <div class="card-body">
                <h4 class="card-title white-text">Photos</h4>
            </div>
            <!-- <div class="card-footer">
                <small class="white-text"><a href="<?= $baseUrl ?>/albums/create">Create a new Album</a></small>
            </div> -->
            <a class="btn blue-gradient btn-lg" href="<?= $baseUrl ?>/site/photo">Update Your Head Photo</a>
        </div>
    </div>

</div>

<div class="row mt-5 mb-5 view">
    <a href="<?= $baseUrl ?>/starter/index"><img class="img-fluid" src="<?= $baseUrl.Yii::$app->params['resurl'].'/images/banner2.jpg' ?>"></a>
</div>
