<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
?>
<div class="form-elegant">
    <div class="card rgba-black-strong col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-lg-6 col-lg-offset-3">
        <div class="card-body">
            <div class="text-center">
                <h3 class=""><?= Html::encode($this->title) ?></h3>
            </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>
                
            <div class="mt20 btn-group mdb-btn-group" data-toggle="buttons">

                <?php
                $items = ['fans' => 'fans', 'artist' => 'artist', 'producer' => 'producer' ];

                echo $form->field($model, 'role')->radioList($items, [ 
                    'item' => function ($index, $label, $name, $checked, $value){
                        $html = '<label class="btn btn-blue form-check-label">';
                        if ($value == 'fans') {
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" checked="checked" autocomplete="off">' .$label;
                        } else {
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" autocomplete="off">' .$label;    
                        }
                        
                        $html .= '</label>';

                        return $html;
                    }
                ])->label(false);
                ?>
            </div>
            <div class="md-form">
                <?= $form->field($model, 'email') ?>
            </div>
            <div class="md-form">
                <?= $form->field($model, 'username') ?>
            </div>
            <div class="md-form">
                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>
            </div>
            <div class="md-form">
                <?php 
                    echo $form->field($model, 'country')->widget(Select2::classname(), [
                    'data' => $country,
                    'options' => ['placeholder' => '--select a country--'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        'change' => 'function() {
                            var id = $(this).val(),
                            url = "registration/getcities",
                            data = {
                                "id":id,
                            };
                        //console.log(data);
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success:function(resp){
                                if (resp && resp != 0) {
                                    //console.log(resp);
                                    var items = $.parseJSON(resp);
                                    //console.log(items);
                                    if (items) {
                                        html = "";
                                        for(i = 0;i < items.length;i++){
                                            var item = items[i];
                                            
                                            html += "<option value=" + item.id+">" + item.name +"</option>"
                                            //console.log(html);
                                        }
                                        //console.log(html);
                                        $("#register-form-city").html(html);
                                        
                                    } else {
                                        //console.log("error no items");
                                    }
                                } else {
                                    $("#register-form-city").html("<option value=0>No area selected</option>");
                                }
                            },
                            error:function(){
                                console.log("Failed request data from AJAX request");
                            },
                            dataType: "text"
                        });
                        }'
                    ],
                ])->label('Country');
                ?>
            </div>
            <div class="md-form">
                <?php 
                    echo $form->field($model, 'city')->widget(Select2::classname(), [
                    'data' => [],
                    'options' => ['placeholder' => '--select a city--'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                    ],
                ])->label('Area');
                ?>
            </div>
                <div class="mt20 btn-group mdb-btn-group" data-toggle="buttons">
                <?php
                echo $form->field($model, 'gender')->radioList(['male' => 'Male', 'female' => 'Female', 'secret' => 'Prefer not to say'], [ 
                    'item' => function ($index, $label, $name, $checked, $value){
                        $html = '<label class="btn btn-blue form-check-label">';
                        if ($checked) {
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" checked="checked" autocomplete="off">' .$label;
                        } else {
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" autocomplete="off">' .$label;    
                        }
                        
                        $html .= '</label>';

                        return $html;
                    }
                ]);
                ?> 
                </div>
                <div class="md-form">
                <?php
                echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    //'value' => 'Tue, 23-Feb-1982',
                    //'value' => date('d-M-Y', strtotime($model->birthday)),
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format'=>'d-M-yyyy',
                        
                    ]
                ]);
                ?>
                </div>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>

