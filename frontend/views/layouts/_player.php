<?php

use yii\helpers\Html;
use yii\helpers\Url;

$weburl = Url::to("@web");

$this->registerCssFile($weburl.'/frontend/web/lib/SoundManager/vert-player/css/bar-ui.css', [], 'css-bar-ui');

$this->registerJsFile($weburl.'/frontend/web/lib/SoundManager/script/soundmanager2.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($weburl.'/frontend/web/lib/SoundManager/vert-player/script/bar-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($weburl.'/frontend/web/js/player-io.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="container fixed">
<div class="sm2-bar-ui full-width fixed userid" userid="<?= $userid ?>">


<div class="bd sm2-main-controls">

    <div class="sm2-inline-texture"></div>
    <div class="sm2-inline-gradient"></div>

    <div class="sm2-inline-element sm2-button-element">
    <div class="sm2-button-bd">
        <a href="#play" class="sm2-inline-button sm2-icon-play-pause">Play / pause</a>
    </div>
    </div>

    <div class="sm2-inline-element sm2-inline-status">

    <div class="sm2-playlist">
    <div class="sm2-playlist-target">
        <!-- <ul><li><a href="http://localhost/music/frontend/web/uploads/22/tracks_2/-PITNbh_X7H0YVDQPnNmyclc9mtjfQI1.mp3"><b>ROYAL</b></a></li></ul> -->
     <!-- playlist <ul> + <li> markup will be injected here -->
     <!-- if you want default / non-JS content, you can put that here. -->
     <noscript><p>JavaScript is required.</p></noscript>
    </div>
    </div>

    <div class="sm2-progress">
        <div class="sm2-row">
            <div class="sm2-inline-time">0:00</div>
            <div class="sm2-progress-bd">
            <div class="sm2-progress-track">
            <div class="sm2-progress-bar"></div>
            <div class="sm2-progress-ball"><div class="icon-overlay"></div></div>
            </div>
            </div>
            <div class="sm2-inline-duration">0:00</div>
        </div>
    </div>

    </div>

    <div class="sm2-inline-element sm2-button-element sm2-volume">
        <div class="sm2-button-bd">
        <span class="sm2-inline-button sm2-volume-control volume-shade"></span>
        <a href="#volume" class="sm2-inline-button sm2-volume-control">volume</a>
        </div>
    </div>

    <div class="sm2-inline-element sm2-button-element">
    <div class="sm2-button-bd">
    <a href="#prev" title="Previous" class="sm2-inline-button sm2-icon-previous">&lt; previous</a>
    </div>
    </div>

    <div class="sm2-inline-element sm2-button-element">
    <div class="sm2-button-bd">
    <a href="#next" title="Next" class="sm2-inline-button sm2-icon-next">&gt; next</a>
    </div>
    </div>

    <div class="sm2-inline-element sm2-button-element">
        <div class="sm2-button-bd">
        <a href="#repeat" title="Repeat playlist" class="sm2-inline-button sm2-icon-repeat">&infin; repeat</a>
        </div>
    </div>

    <!-- not implemented -->
    <!--
    <div class="sm2-inline-element sm2-button-element disabled">
    <div class="sm2-button-bd">
    <a href="#shuffle" title="Shuffle" class="sm2-inline-button sm2-icon-shuffle">shuffle</a>
    </div>
    </div>
    -->

    <!-- <div class="sm2-inline-element sm2-button-element sm2-menu">
    <div class="sm2-button-bd">
    <a href="#clearlist" class="sm2-inline-button sm2-icon-clearlist" title="Clear list">clearlist</a>
    </div>
    </div> -->

    <div class="sm2-inline-element sm2-button-element sm2-menu">
    <div class="sm2-button-bd">
    <a href="#menu" class="sm2-inline-button sm2-icon-menu">menu</a>
    </div>
    </div>

</div>

<div class="bd sm2-playlist-drawer sm2-element">
    <div class="playlist_user mb-3" id="user_playlist" style="display: none;">
        <div class="row">
            <div class="col">
            <h3 class="d-inline ml-3 float-left mt-3">Playlist <small><a title="Manage your playlists." href="<?= $weburl ?>/playlist"><i class="fas fa-cog"></i></a></small></h3>
            <div class="spinner"></div>
            <ul class="nav nav-pills float-left" id="playlist_list">
                
            </ul>
            </div>
        </div>
    </div>
    <hr />
    <!-- <div class="sm2-inline-texture">
        <div class="sm2-box-shadow"></div>
    </div> -->

    <!-- playlist content is mirrored here -->

    <div class="sm2-playlist-wrapper">
    

    <ul class="sm2-playlist-bd">
        <!-- standard one-line items -->
        <!-- 
            <div class="sm2-row">
                <div class="sm2-col sm2-wide">
                <a href="http://freshly-ground.com/data/audio/sm2/Figub%20Brazlevi%C4%8D%20-%20Bosnian%20Syndicate.mp3" class="exclude button-exclude inline-exclude"><b>Figub Brazlevič</b> - Bosnian Syndicate <span title="Published under a Creative Commons BY-NC-ND license" class="label">(BY-CC-ND license)</span></a>
                </div>
                <div class="sm2-col">
                <a href="http://freshly-ground.com/data/audio/sm2/Figub%20Brazlevi%C4%8D%20-%20Bosnian%20Syndicate.mp3" target="_blank" title="Download &quot;Bosnian Syndicate&quot;" class="sm2-icon sm2-music sm2-exclude">Download this track</a>
                </div>
            </div>
        </li> -->
    </ul>

    </div>

</div>

</div>
</div>
<?= $this->render('/layouts/_playlist') ?>
