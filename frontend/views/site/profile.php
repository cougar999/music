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
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\Helpers;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;

$helper = new Helpers;
$country = $helper->getCountries();
$city = $helper->getCities();
$weburl = Url::to("@web");
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */
$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
$model->birthday = date('d-M-Y', strtotime($model->birthday));
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_user_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>

                <?php /* $form->field($model, 'name') */?>

                
                <?= $form->field($model, 'website') ?>
                <?php
                echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    //'value' => 'Tue, 23-Feb-1982',
                    'value' => date('d-M-Y', strtotime($model->birthday)),
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format'=>'d-M-yyyy',
                    ]
                ]);
                ?>
                
                <div class="mt20 btn-group mdb-btn-group" data-toggle="buttons" style="display: block;">
                <?php
                $genders = ['male' => 'Male', 'female' => 'Female', 'secret' => 'Prefer not to say'];

                echo $form->field($model, 'gender')->radioList($genders, [ 
                    'item' => function ($index, $label, $name, $checked, $value){
                        
                        if ($checked) {
                            $html = '<label class="btn btn-blue form-check-label waves-effect waves-light active">';
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" checked="checked" autocomplete="off">' .$label;
                        } else {
                            $html = '<label class="btn btn-blue form-check-label waves-effect waves-light">';
                            $html .= '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '" autocomplete="off">' .$label;    
                        }
                        
                        $html .= '</label>';

                        return $html;
                    }
                ]);
                ?>
                </div>

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
                            url = "'.$weburl.'/user/registration/getcities",
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
                                        $("#profile-city").html(html);
                                        
                                    } else {
                                        //console.log("error no items");
                                    }
                                } else {
                                    $("#profile-city").html("<option value=0>No area selected</option>");
                                }
                            },
                            error:function(){
                                console.log("Failed request data from AJAX request");
                            },
                            dataType: "text"
                        });
                        }'
                    ],
                ]);
                ?>
                <?php 
                    echo $form->field($model, 'city')->widget(Select2::classname(), [
                    'data' => $city,
                    'options' => ['placeholder' => '--select a city--'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                    ],
                ]);
                ?>

                <?= $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        ArrayHelper::map(
                            Timezone::getAll(),
                            'timezone',
                            'name'
                        )
                    ); ?>

                <?php /* $form->field($model, 'public_email') */?>
                <?php /* $form
                    ->field($model, 'gravatar_email')
                    ->hint(Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) */?>

                <?= $form->field($model, 'bio')->textarea() ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
                        <br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
