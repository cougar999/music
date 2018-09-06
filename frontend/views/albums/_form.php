<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
/* @var $form yii\widgets\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
$model->first_release_date = date('d-M-Y', strtotime($model->first_release_date));
?>

<div class="albums-form row">

    <?php $form = ActiveForm::begin(); ?>
        
            <div class="col-md-12 col-sm-12 col-lg-12">
            <?= $form->field($model, 'album_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6 col-sm-12 col-lg-6">
        
            <?php
                echo $form->field($model, 'language')->widget(Select2::classname(), [
                'data' => $language,
                'options' => [
                    'placeholder' => '--select a language you speaking--'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                ],
            ]);
            ?>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-6">

            <?php
                $type1 = ['1' => 'Single', '2' => 'Album'];
                echo $form->field($model, 'type')->widget(Select2::classname(), [
                'data' => $type1,
                'options' => [
                    'placeholder' => '--Single or Album ?--', 
                    'value' => '2'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                ],
            ]);
            ?>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-6">

            <?php
                echo $form->field($model, 'genre')->widget(Select2::classname(), [
                'data' => $genre,
                'showToggleAll' => false,
                'options' => [
                    'placeholder' => '--select Genres--',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'maximumSelectionLength' => 3,
                ],
                'pluginEvents' => [
                ],
            ]);
            ?>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-6">

            <?php
            echo $form->field($model, 'first_release_date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                //'value' => 'Tue, 23-Feb-1982',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-M-yyyy',
                ],
            ]);
            ?>
            </div>

            <div class="col-md-12 col-sm-12 col-lg-12">

            <?= $form->field($model, 'album_description')->textarea(['rows' => 5]) ?>

            <?php
            
            if (!isset($model->cover)) {
                echo $form->field($model, 'cover')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'removeLabel' => '',
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
                        'removeLabel' => '',
                        'browseLabel' => '',
                        'showCaption' => false,
                        'showRemove' => true,
                        'showUpload' => false,
                        //'showPreview' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  'Select Cover',
                        'initialPreview'=>[
                            Url::base() . $imageUrl. $filename .'.'.$ext,
                        ],
                        'initialPreviewAsData'=>true,
                        'maxFileSize' => 3000,
                    ],

                ]);
                
            }
            ?>
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12">

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
            </div>


    <?php ActiveForm::end(); ?>

</div>

<?php 
$script1 = <<< JS

$('#albums-cover').on('fileclear', function(event) {
    console.log("fileclear");
    $('form#w0').append('<input name="cover_action" type="hidden" value="delete">');

}); 

$('#albums-cover').on('change', function(event) {
    console.log("change");
    $('form#w0').append('<input name="cover_action" type="hidden" value="update">');
});

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
