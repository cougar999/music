<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PlaylistRelations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="playlist-relations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'track_id')->textInput() ?>

    <?= $form->field($model, 'playlist_id')->textInput() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
