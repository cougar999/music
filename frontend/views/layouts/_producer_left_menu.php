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

    <ul class="nav nav-pills nav-stacked">
        <li <?php if($route == '/producer/index'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/producer/index">PRODUCER INDEX</a>
        </li>
    </ul>

</div>
