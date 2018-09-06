<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\BaseUrl;



$this->title = 'Update Photo';
$this->params['breadcrumbs'][] = $this->title;

$weburl = Url::to("@web");

$this->registerCssFile($weburl.'/frontend/web/lib/Jcrop/css/jquery.Jcrop.css', [], 'css-jcrop');
$this->registerJsFile($weburl.'/frontend/web/lib/Jcrop/js/jquery.Jcrop.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($weburl.'/frontend/web/lib/Jcrop/js/jquery.color.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="site-photo">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
    	<div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xs-12 mt20">
		<?php $form = ActiveForm::begin(); ?>
		
		<?php			
		echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
            'id' => 'imglarge',
		    'options' => ['accept' => 'image/*'],
		    'pluginOptions' => [
		        'showPreview' => false,
		        'showCaption' => false,
		        'showRemove' => false,
		        'showUpload' => false,
		        'browseClass' => 'btn btn-primary btn-block',
		        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        		'browseLabel' =>  'Select Photo',
        		'maxFileSize' => 3000,
        		'showUploadedThumbs' => false
		    ]
        ])->label(false);
		?>

		<div id="target" style="width: 550px; height:auto;">
		</div>

		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />

		<div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

    	<?php ActiveForm::end(); ?>
    	</div>
    </div>

</div>


<?php 
$script1 = <<< JS

jQuery(function($){

	$('#images-avatar').on('change', function(event) {
		var file = this.files[0];
		var bwidth = '100px';
		var bheight = '100px';
		var oWidth = $('#target').width(); 
		var oHeight = $('#target').height();

		if(file) {
			var reader = new FileReader();
			reader.onload = function(e) {
	    		$("#target").html('').append('<img src='+reader.result+'>');

	    		var start_time = new Date().getTime()
				var img = new Image();
				
				img.src = reader.result;
				var check = function(){
					if (img.width>0 || img.height>0) {
						//console.log(img.width, img.height);
						clearInterval(set);
					}
				}
				var set = setInterval(check,40);

				img.onload = function() {
					
					// $("#target").css({
					// 	width:img.width/2,
					// 	height:img.height/2
					// });
					$('#target').Jcrop({
						aspectRatio:1/1,
						minSize:[100, 100],
						maxSize:[400, 400],
						onSelect: updateCoords,
						onChange: updateCoords,
					},function(){
				      // Use the API to get the real image size
				      var bounds = this.getBounds();
				      boundx = bounds[0];
				      boundy = bounds[1];
				      // Store the API in the jcrop_api variable
				      jcrop_api = this;

				    });
					var diff = new Date().getTime() - start_time;
					console.log(diff, img.width, img.height)
				}

			}
			reader.readAsDataURL(file);
			
		}
   });


});

function updateCoords(c)
{
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
};


JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>