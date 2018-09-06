<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = $title;
?>
<div class="fans-index">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
            <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
			<h1><?= Html::encode($this->title) ?></h1>
			<div class="row">
	            <?= ListView::widget([
	                'dataProvider' => $dataProvider,
	                'itemOptions' => [
	                    'class' => 'item'
	                ],
	                'itemView' => '_item_list_common',
	                'viewParams' => [
	                    'baseurl' => Url::home()
	                ],
	            ]) ?>
	            </div>
	        </div>
        </div>

    </div>


</div>
<?php 
$script1 = <<< JS

$('.thumbnail').on('mouseover', function(event) {
    $(this).find('.text').show();
}); 
$('.thumbnail').on('mouseout', function(event) {
    $(this).find('.text').hide();
}); 

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>