<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TracksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tracks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'album_id') ?>

    <?= $form->field($model, 'cover') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'artist_id') ?>

    <?php // echo $form->field($model, 'lyricist') ?>

    <?php // echo $form->field($model, 'composer') ?>

    <?php // echo $form->field($model, 'arrangement') ?>

    <?php // echo $form->field($model, 'lyrics') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'created_user') ?>

    <?php // echo $form->field($model, 'updated_user') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
