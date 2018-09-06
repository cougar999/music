<?php

use yii\helpers\Html;
use yii\helpers\Url;

$weburl = Url::to("@web");

$this->registerJsFile($weburl.'/frontend/web/js/playlist.js?ver20180726', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<!-- Modal: playlistModal -->
<div class="modal fade rgba-black-strong" id="playlistModal" tabindex="-1" role="dialog" aria-labelledby="playlistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-info" role="document">
        <div class="modal-content">
            <!--Body-->
            <div class="modal-header">
                <p class="heading h2 black-text"> Save to Playlist</p>
            </div>
            <div class="modal-body">

                <iframe src="" width="100%" height="400" frameborder="0" id="playlist-frame"></iframe>

            </div>
            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal: playlistModal -->

<?php 
$script1 = <<< JS

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
