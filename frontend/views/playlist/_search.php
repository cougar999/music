<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model frontend\models\PlaylistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="playlist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

    <?php // $form->field($model, 'id') ?>
    <div class="col-md-4 col-sm-12 col-lg-4">
    <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-md-3 col-sm-12 col-lg-3">
    <?= $form->field($model, 'note') ?>
    </div>
    <div class="col-md-2 col-sm-12 col-lg-2">
    <?php // $form->field($model, 'active') ?>
    <?php
        $active = ['0' => 'inactive', '1' => 'active'];
        echo $form->field($model, 'active')->widget(Select2::classname(), [
        'data' => $active,
        'options' => ['placeholder' => '--active--'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'pluginEvents' => [
        ],
    ]);
    ?>
    </div>

    <?php // $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'created_user') ?>

    <?php // echo $form->field($model, 'updated_user') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Create Playlist'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
