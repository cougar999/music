<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
?>


<div class="message-page">
    <div class="row ">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">

        	<?php if(isset($_GET['id']) && $_GET['id'] != NULL): ?>
              
	        	<h1>Genre: <?= $model->name ?></h1>
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

            <?php else : ?>

                <div id="genrelist">
                <h1>Genre List</h1>
                
                <?php foreach ($model as $key => $value): ?>
                <?php
                    $num = $key % 6;
                    if ($num && $num > 4) {
                        $color = 'green';
                    } elseif ($num && $num > 3 ) {
                        $color = 'pink';
                    } elseif ($num && $num > 2 ) {
                        $color = 'light-blue';
                    } elseif ($num && $num > 1 ) {
                        $color = 'purple';
                    } elseif ($num && $num > 0 ) {
                        $color = 'orange';
                    } else {
                        $color = 'indigo';
                    }
                ?>
                <a href="index?id=<?= $value->id ?>" class="animated badge badge-pill h2 <?= $color ?> waves-effect waves-light rgba-white-slight"><?= $value->name ?></a>
                <?php endforeach ?>
                </div>
            <?php endif; ?>
	
        </div>
    </div>
</div>
<?php 
$script1 = <<< JS

$(document).on('mouseenter', 'a.badge', function(event) {
    if($(this).hasClass('flipInX')) {
        $(this).removeClass('flipInX').delay(1000);
    }
    $(this).addClass('flipInX');
}); 

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>