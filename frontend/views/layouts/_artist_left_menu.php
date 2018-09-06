<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\BaseUrl;
use kartik\sidenav\SideNav;
/* @var $this yii\web\View */
$url = Url::to("@web");
$route = '/'.Yii::$app->requestedRoute;
?>

<div id="sidebar" class="sidebar-nav">

    <h5><i class="glyphicon glyphicon-home"></i>
        <small><b>MUSIC MANAGEMENT</b></small>
    </h5>
    <ul class="nav nav-pills nav-stacked">
        <li <?php if($route == '/albums/index'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/albums/index">My Album List</a>
        </li>
        <li <?php if($route == '/albums/create'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/albums/create">Create Album</a>
        </li>
    </ul>
    <!-- <h5><i class="glyphicon glyphicon-user"></i>
        <small><b>USERS</b></small>
    </h5>
    <ul class="nav nav-pills nav-stacked">
        <li><a href="#">Profile</a></li>
        <li><a href="#">Manage</a></li>
    </ul> -->
</div>
