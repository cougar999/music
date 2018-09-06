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

    <?php if(\Yii::$app->user->can('artist')): ?>
        <h5 class="mb-3"><i class="fas fa-music"></i>
            <small><b>SOUND MANAGEMENT</b></small>
        </h5>
        <ul class="nav nav-pills nav-stacked">
            <li <?php if($route == '/artist/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/artist/index"><i class="fas fa-home"></i> HOMEPAGE</a>
            </li>
            <li <?php if($route == '/albums/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/albums/index"><i class="fas fa-images"></i> MY ALBUMS</a>
            </li>
            <li <?php if($route == '/albums/create'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/albums/create"><i class="far fa-plus-square"></i> CREATE ALBUM</a>
            </li>
            <li <?php if($route == '/starter/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/starter/index"><i class="fas fa-star"></i> LISTEN FM</a>
            </li>
            <li <?php if($route == '/playlist/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/playlist/index"><i class="far fa-list-alt"></i> PLAYLIST</a>
            </li>
        </ul>
    <?php elseif(\Yii::$app->user->can('producer')): ?>
        <ul class="nav nav-pills nav-stacked">
            <li <?php if($route == '/producer/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/producer/index"><i class="fas fa-home"></i> HOMEPAGE</a>
            </li>
            <li <?php if($route == '/starter/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/starter/index"><i class="fas fa-star"></i> LISTEN FM</a>
            </li>
            <li <?php if($route == '/playlist/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/playlist/index"><i class="far fa-list-alt"></i> PLAYLIST</a>
            </li>
        </ul>
    <?php else : ?>
        <ul class="nav nav-pills nav-stacked">
            <li <?php if($route == '/fans/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/fans/index"><i class="fas fa-home"></i> HOMEPAGE</a>
            </li>
            <li <?php if($route == '/starter/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/starter/index"><i class="fas fa-star"></i> LISTEN FM</a>
            </li>
            <li <?php if($route == '/playlist/index'){echo 'class="active"';} ?>>
                <a href="<?= $url ?>/playlist/index"><i class="far fa-list-alt"></i> PLAYLIST</a>
            </li>
        </ul>
    <?php endif; ?>


    <h5 class="mt-5 mb-3"><i class="fas fa-headphones"></i>
        <small><b>PICKS</b></small>
    </h5>
    <ul class="nav nav-pills nav-stacked">
        <li <?php if($route == '/site/new'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/site/new"><i class="fas fa-gift"></i> NEW RELEASE</a>
        </li>
        <li <?php if($route == '/site/following'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/site/following"><i class="far fa-heart"></i> FOLLOWING</a>
        </li>
        <li <?php if($route == '/site/trending'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/site/trending"><i class="far fa-thumbs-up"></i> TRENDING</a>
        </li>
        <li <?php if($route == '/genre/'){echo 'class="active"';} ?>>
            <a href="<?= $url ?>/genre/"><i class="fas fa-audio-description"></i> GENRE</a>
        </li>
    </ul>

</div>
