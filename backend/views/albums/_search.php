<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'album_name') ?>

    <?= $form->field($model, 'album_descption') ?>

    <?= $form->field($model, 'language') ?>

    <?= $form->field($model, 'cover') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'first_release_date') ?>

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
