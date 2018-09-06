<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Playlists');
$weburl = Url::to("@web");

$this->registerJsFile($weburl.'/frontend/web/js/playlist.js?ver2018072601', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<style type="text/css">
    html, body {
        background: none;
    }
</style>
<table class="table table-hover grey darken-2" id="playlist-table">

    <!--Table head-->
    <thead>
        <tr>
            <th width="50">&nbsp;</th>
            <th>Please pick a Playlist from this list:</th>
        </tr>
    </thead>
    <!--Table head-->

    <!--Table body-->
    <tbody>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                $num = $index + 1;
                $html = '<tr>';
                $html .= '<th scope="row">'.$num .'</th>';
                $html .= '<td>'.Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'd-block addtoPlaylist', 'data-trackid' => 0, 'playlist-id' => $model->id]).'</td>';
                $html .= '</tr>';

                return $html; //Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
            },
            'viewParams' => [
                'baseurl' => Url::home()
            ],
            'summary' => ''
        ]) ?>
    </tbody>
    <!--Table body-->

</table>

<?= Html::a(Yii::t('app', 'Create New Playlist'), ['createinlist'], ['class' => 'btn btn-success']) ?>
<?= Html::a(Yii::t('app', 'Manage Playlist'), ['index'], ['class' => 'btn btn-info', 'target' => '_parent']) ?>

<div class="modal fade" id="ModalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-notify modal-success" role="document" id="modalbg">
    <!--Content-->
    <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
            <p class="heading lead"></p>
        </div>

        <!--Body-->
        <div class="modal-body">
            <div class="text-center">
                <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
                <p></p>
            </div>
        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
            <a type="button" class="btn btn-success waves-effect" data-dismiss="modal">CLOSE</a>
        </div>
    </div>
    <!--/.Content-->
</div>
</div>
