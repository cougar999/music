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

$this->registerCssFile($weburl.'/frontend/web/lib/cropperjs/dist/cropper.css', [], 'css-cropper');
$this->registerJsFile($weburl.'/frontend/web/lib/cropperjs/dist/cropper.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($weburl.'/frontend/web/lib/Jquery-cropper/dist/jquery-cropper.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

if (isset($model) && isset($model->url)) {
	$imgurl = $weburl.$model->url.'/'.$model->filename.'.'.$model->ext;
} else {
	$imgurl = $weburl.'/frontend/web/images/avatar_default2.jpg';
}
?>
<div class="site-photo">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
    	<div class="col-md-2 col-lg-2 col-xs-12 mt20">
    		<div class="row">
    			<h4>Current:</h4>
    			<div class="current-img preview-lg" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom" data-delay="500">
    				<img src="<?= $imgurl ?>" alt="current photo" id="current_img">
    			</div>
    		</div>
    		<div class="row">
    			<h4>Preview:</h4>
    			<div class="img-preview preview-lg"></div>
    		</div>
    		
    	</div>
    	<div class="col-md-8 col-lg-8 col-xs-12 mt20">

		<div class="btn-group mb20" role="group" aria-label="...">
			<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
				<input type="file" class="sr-only" id="inputImage" name="avatar-file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
			  <i class="fas fa-upload"> </i> Choose photos
			</label>
				<button id="submitImage" class="btn btn-primary">Upload</button>
		</div>


		<div id="target" style="width: 100%; height:auto;">
			<img src="" alt="">
		</div>

<!-- 	<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" /> --> 

    	</div>
    </div>

</div>

<div id="upload-success" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Uploading</h4>
      </div>
      <div class="modal-body">
      	<div class="progress">
		  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		  </div>
		</div>
        <span class="success-text" style="display: none;">You photo has been successful changed!</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<?php 
$script1 = <<< JS

$(function () {
	'use strict';
	var console = window.console || { log: function () {} };
	var URL = window.URL || window.webkitURL;
	var options = {
		aspectRatio: 1 / 1,
		preview: '.img-preview',
		viewMode:2,
		minCropBoxWidth:300,
		minCropBoxHeight:300,
		crop: function (e) {
		$('#x').val(Math.round(e.detail.x));
		$('#y').val(Math.round(e.detail.y));
		$('#h').val(Math.round(e.detail.height));
		$('#w').val(Math.round(e.detail.width));
		// console.log(e.detail.rotate);
		// console.log(e.detail.scaleX);
		// console.log(e.detail.scaleY);
		}
	};
	var _image = $('#target img');
	var inputImage = $('#inputImage');
	var uploadedImageURL;
	var uploadImage = $('#uploadImage');
	
	_image.cropper(options);

	if (URL) {
    inputImage.change(function () {
      var files = this.files;
      var file;

      if (!_image.data('cropper')) {
        return;
      }

      if (files && files.length) {
        file = files[0];

        if (/^image\/\w+$/.test(file.type)) {

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }

          uploadedImageURL = URL.createObjectURL(file);
          _image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
          inputImage.val('');
        } else {
          window.alert('Please choose an image file.');
        }
      }
    });
  } else {
    inputImage.prop('disabled', true).parent().addClass('disabled');
  }

	
	$('#submitImage').on('click', function() {
		$('#upload-success').modal();
		uploadImagebyAjax();
	})

	function uploadImagebyAjax() {
		_image.cropper('getCroppedCanvas').toBlob(function (blob) {
			var formData = new FormData();

  			formData.append('croppedImage', blob);

	        $.ajax({
		        url: 'photo', // 要上传的地址
		        type: 'POST',
		        data: formData,
		        processData: false,
    			contentType: false,
		        dataType: 'json',
		        success: function (data) {
		        	var item = $.parseJSON(data);
		            if (item[0].result > 0) {
						console.log(item);
						$("#current_img, #user_photo").attr('src', item[0].url);
						//$('.current-img').tooltip('show');
						//$('#upload-success').modal();
						$('.progress').hide();
						$('.success-text').show();
	
		            } else {
		            	$('.progress').hide();
		            	$('.success-text').text('Sorry, Something wrong, please try again later.').show();
		                console.log("something wrong",item);
		            }
		        },
		        error:function(e){
		        	$('.progress').hide();
		        	$('.success-text').text('Sorry, Something wrong, please try again later.').show();
		            console.log("Failed request data from AJAX request",e);
		        },
		    });

	    });
		
	}



});

JS;
$this->registerJs($script1, \yii\web\View::POS_END);   
?>
