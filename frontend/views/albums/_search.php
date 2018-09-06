<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\AlbumsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="albums-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-lg-3">
            <?= $form->field($model, 'album_name') ?>
        </div>
        <div class="col-md-2 col-sm-12 col-lg-2">
            <?php
                $type1 = ['1' => 'Single', '2' => 'Album'];
                echo $form->field($model, 'type')->widget(Select2::classname(), [
                'data' => $type1,
                'options' => ['placeholder' => '--Single or Album?--'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                ],
            ]);
            ?>
        </div>
        <div class="col-md-3 col-sm-12 col-lg-3">
            <?php // $form->field($model, 'album_description') ?>

            <?php // echo $form->field($model, 'first_release_date') ?>

            <?php // echo $form->field($model, 'created_time') ?>

            <?php // echo $form->field($model, 'updated_time') ?>

            <?php // echo $form->field($model, 'created_user') ?>

            <?php // echo $form->field($model, 'updated_user') ?>

            <div class="form-group">
                    <label class="control-label" style="width: 160px;">&nbsp;</label>
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>


        
    </div>
    

    

    <?php ActiveForm::end(); ?>

</div>
