<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="albums-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'album_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'album_descption')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'language')->textInput() ?>

    <?= $form->field($model, 'cover')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'first_release_date')->textInput() ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <?= $form->field($model, 'created_user')->textInput() ?>

    <?= $form->field($model, 'updated_user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
