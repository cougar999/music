<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Follow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="follow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'source_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <?= $form->field($model, 'created_user')->textInput() ?>

    <?= $form->field($model, 'updated_user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
