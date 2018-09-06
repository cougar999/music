<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Playlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="playlist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'public')->radioList(
        ['1'=>'Yes',0=>'No'],
        [
        'item' => function($index, $label, $name, $checked, $value) {

            $return = '<div class="form-check form-check-inline">';
            
            if ($checked) {
                $return .= '<input class="form-check-input" id="'.$label.$index.'" type="radio" name="' . $name . '" value="' . $value . '" tabindex="'.$index.'" checked="'.$checked.'">';
            } else {
                $return .= '<input class="form-check-input" id="'.$label.$index.'" type="radio" name="' . $name . '" value="' . $value . '" tabindex="'.$index.'">';
            }
            
            $return .= '<label class="form-check-label" for="' . $label . $index.'">'.$label.'</label></div>';

            return $return;
        }
        ]
    )->hint("When this setting is 'Yes', every user may see this playlist"); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
