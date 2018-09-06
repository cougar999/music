<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;

$baseUrl = Url::base();
$webUrl = Yii::getAlias('@web');
//var_dump($model);
?>


<?php if(isset($genre_ids) && $genre_ids != NULL): ?>
<h1 class="mb-5 text-center">Your Current Picks:</h1>
<div class="row text-center mb-5">

<?php foreach ($genre_ids as $num => $val): ?>

<button class="btn btn-rounded blue-gradient"><?= $indexed_genre[$val]->name ?></button>

<?php endforeach ?>

</div>
<?php endif; ?>

<h1 class="mb-5 text-center">Pick or Update The Genres:</h1>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
		<?php if(isset($model) && $model != NULL): ?>
		<?php foreach ($model as $key => $value): ?>
			<?php
                /*
                $num = $key % 6;
                if ($num && $num > 4) {
                    $color = 'red-text';
                } elseif ($num && $num > 3 ) {
                    $color = 'pink-text';
                } elseif ($num && $num > 2 ) {
                    $color = 'purple-text';
                } elseif ($num && $num > 1 ) {
                    $color = 'blue-text';
                } elseif ($num && $num > 0 ) {
                    $color = 'cyan-text';
                } else {
                    $color = 'lime-text';
                }*/
            ?>

		    <div class="form-check col-lg-2 col-md-2 mb-3">
		        <input class="form-check-input" name="genre[]" type="checkbox" id="<?= $value->name ?>" value="<?= $value->id ?>" <?= isset($genre_ids) && in_array($value->id, $genre_ids) ? 'checked="checked"' : ''; ?>>
		        <label class="form-check-label " for="<?= $value->name ?>"><?= $value->name ?></label>
		    </div>

		<?php endforeach ?>
		<?php endif; ?>
</div>

<div class="clearfix text-center mt-5">
	<button type="submit" class="btn purple-gradient btn-lg">Next</button>
</div>

<!-- Central Modal Small -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header danger-color-dark">
                <h5 class="modal-title pull-left" id="errorModalLabel">Warm Reminder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="black-text">Sorry, you only can choose 5 options maxmium.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>


<?php 
$script1 = <<< JS

function checkBoxes() {
    var elems = $('form').find('input[type=checkbox]:checked');
    return elems.length;
}

$(document).on('click', 'input[type=checkbox]', function(event) {
    var nums = checkBoxes();
    if(nums && nums > 5){
        $('#errorModal').modal();
        return false;
    }
    
});

$( "form" ).submit(function( event ) {
    var nums = checkBoxes();
    if(nums && nums > 5){
        $('#errorModal').modal();
        return false;
    }
});


JS;
$this->registerJs($script1, \yii\web\View::POS_END);
?>

