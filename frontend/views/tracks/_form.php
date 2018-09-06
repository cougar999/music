<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tracks */
/* @var $form yii\widgets\ActiveForm */
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\BaseUrl;

$request = Yii::$app->request->get();
$album_id = isset($request['album_id']) ? $request['album_id'] : $model->album_id;

//var_dump($image, $track);
?>

<div class="tracks-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'album_id')->hiddenInput(['value' => $album_id, 'readonly' => 'readonly'])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?php 
    /* Don't need a cover for track at this moment
    if (!isset($model->cover)) {
        echo $form->field($model, 'cover')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Photo',
                'maxFileSize' => 3000
            ],
        ]);

    } else {
        $imageUrl = $image != null ? $image->url : '';
        $filename = $image != null ? $image->filename : null;

        $ext = $image != null ? $image->ext : null;
        echo $form->field($model, 'cover')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Cover',
                'initialPreview'=>[
                    Url::base() . $imageUrl. $filename .'.'.$ext,
                ],
                'initialPreviewAsData'=>true,
                'maxFileSize' => 3000
            ],

        ]);
        
    }*/
    ?>

    <?php 
    if (!isset($model->url) && count($model->url) < 1) {
        echo $form->field($model, 'url')->widget(FileInput::classname(), [
            'options' => ['accept' => 'audio/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fas fa-cloud-upload-alt"></i> ',
                'browseLabel' =>  'Select Music Tracks',
                'maxFileSize' => 10000
            ],
        ]);
    } else {
        $trackUrl = $track != null ? $track->url : '';
        $trackname = $track != null ? $track->filename : null;
        $ext = $track != null ? $track->ext : null;

        if (count($track) >= 1) {
            $html = '<div id="track_player"><audio controls>';
        
            $html .= '<source src="'.Url::base() . $trackUrl. $trackname .'.'.$ext.'" type="audio/mpeg">Your browser does not support the audio element.</audio></div>';

            echo $html;

            echo '<a id="removeTrack" class="btn btn-default" href="/music/tracks/#" onclick="javascript:void(0);"><i class="glyphicon glyphicon-trash"></i> Remove</a>';
        }

        echo $form->field($model, 'url')->widget(FileInput::classname(), [
            'options' => ['accept' => 'audio/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Select Another Music Track',
                //'initialPreview'=>[
                   // Url::base() . $trackUrl. $trackname .'.'.$ext,
                //],
                //'initialPreviewFileType' => 'audio',
                //'initialPreviewAsData' => true,
                'maxFileSize' => 10000,
            ],
        ]);
    }
    ?>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-lg-6">

            <?= $form->field($model, 'artist_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6">
        <?= $form->field($model, 'lyricist')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-lg-6">
        <?= $form->field($model, 'composer')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6">
        <?= $form->field($model, 'arrangement')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'lyrics')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$script1 = <<< JS

$('#tracks-cover').on('fileclear', function(event) {
    console.log("fileclear");
    $('form#w0').append('<input name="cover_action" type="hidden" value="delete">');

}); 

$('#tracks-cover').on('change', function(event) {
    console.log("change");
    $('form#w0').append('<input name="cover_action" type="hidden" value="update">');
});

$('#tracks-url').on('fileclear', function(event) {
    console.log("fileclear");
    $('form#w0').append('<input name="track_action" type="hidden" value="delete">');

}); 

$('#tracks-url').on('change', function(event) {
    console.log("change");
    $('form#w0').append('<input name="track_action" type="hidden" value="update">');
});

$('#removeTrack').on('click', function(){
    $('#tracks-url').val('');
    $('#track_player').html('');
    $('form#w0').append('<input name="track_action" type="hidden" value="delete">');
    $('#removeTrack').remove();
    return false;
})

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
