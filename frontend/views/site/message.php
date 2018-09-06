<?php
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\BaseUrl;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'Messages';

$baseUrl = Url::base();
// embed js for likes or follow
//$this->registerJsFile($baseUrl.'/frontend/web/js/actions.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<?php Pjax::begin(['id' => 'message_container']); ?>
	
	<div class="message-page">

	    <div class="row ">
	        <div class="col-md-2 col-sm-12 col-lg-2">
	        <?= $this->render('/layouts/_common_left_menu') ?>
	        </div>
	        <div class="col-md-10 col-sm-12 col-lg-8">
					<h1 class="mb20"><?= Html::encode($this->title) ?></h1>
					<?php if(isset($messageList['list']) && count($messageList['list']) > 0): ?>
						<ul class="list-unstyled">
						<?php foreach($messageList['list'] as $key=> $value): ?>
							    <li class="media">
							        
							        <div class="media-body">
							            <h5 class="mt-0 mb-1 font-weight-bold">
							            	<?= $value['checked'] != 1 ? '<span class="badge red">NEW</span>' : ''; ?>
							            	<?= $value['title'] ?>
							            		
							            	<span class="float-right">
							            		<a href="#<?= $value['id']?>" class="readMessage mr-2" msgid="<?= $value['id']?>" title="Mark as read"><i class="far fa-check-circle"></i></a> 
							            		<a href="#<?= $value['id']?>" class="removeMessage" msgid="<?= $value['id']?>" title="Remove this message"><i class="far fa-trash-alt"></i></a>
							            	</span>
							            	</h5>
							            <?= $value['body'] ?> <p class="grey-text"><small><?= date('F j, Y, g:i a', $value['create_time']) ?></small></p>
							        </div>
							    </li>
						<?php endforeach; ?>
						</ul>

						<?php
						echo LinkPager::widget([
						    'pagination' => $messageList['pagination'],
						    'options' => ['class' => 'pagination pg-dark']
						]);
						?>

					<?php else : ?>

						<p>You do not have any message yet.</p>

					<?php endif; ?>
	        </div>
	    </div>

	</div>

<?php Pjax::end(); ?>

<?php 
$script1 = <<< JS

$(document).ready(function(){

	// $('.reload').on('click', function(event) {
	// 	 $.pjax.reload({container:"#message_container"});
	// });
	// return false;
});
JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>


