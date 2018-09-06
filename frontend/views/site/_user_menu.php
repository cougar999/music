<?php
use yii\helpers\Html;
use dektrium\user\widgets\UserMenu;
use common\components\Helpers;
use yii\helpers\Url;
use yii\helpers\BaseUrl;


$helpers = new Helpers;
$avatar = $helpers->getAvatar();
$user = Yii::$app->user->identity;

$weburl = Url::to("@web");
$route = '/'.Yii::$app->requestedRoute;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Html::img($avatar, [
                'class' => 'img-rounded',
                'alt' => $user->username,
                'style' => 'width:25px;height:25px;'
            ]) ?>
            <?= $user->username ?>
        </h3>
    </div>
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if($route == '/user/settings/profile'){echo 'class="active"';} ?>><a href="<?= $weburl ?>/user/settings/profile">Profile</a></li>
            <li <?php if($route == '/user/settings/account'){echo 'class="active"';} ?>><a href="<?= $weburl ?>/user/settings/account">Account</a></li>
            <li <?php if($route == '/user/settings/social'){echo 'class="active"';} ?>><a href="<?= $weburl ?>/user/settings/social">Social</a></li>
        </ul>
    </div>
</div>
