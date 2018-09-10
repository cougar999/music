<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

?>


<?php if(isset($model)): ?>
    <?php var_dump($model); ?>
    <tr>
        <td>
            <a href="<?= base64_encode(base64_encode($model->id.'-'.$model->name)); ?>" title="<?= $model->name ?>" data-trackid="<?= $model->id ?>" target="_blank" class="songplaybtn d-block"><?= $model->name ?></a>
        </td>
        <td>
            <i class="fa fa-heart"></i>  <span class="small"><?= $model['clicks']['count'] ?></span>
        </td>
        <td class="text-right">
            
            <?php if ($model['allSounds']): ?>
                <a href="<?= base64_encode(base64_encode($model->id.'-'.$model->name)); ?>" title="<?= $model->name ?>" data-trackid="<?= $model->id ?>" target="_blank" class="song2playlist"><span class="fas fa-plus"></span></a>  &nbsp;
                <a href="<?= base64_encode(base64_encode($model->id.'-'.$model->name)); ?>" title="<?= $model->name ?>" data-trackid="<?= $model->id ?>" target="_blank" class="songplaybtn"><span class="far fa-play-circle"></span></a>  &nbsp;
            <?php endif ?>
        </td>
    </tr>
<?php endif; ?>
    


