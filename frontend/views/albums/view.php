<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */
$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

$this->title = $model->album_name;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->album_name.',',
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->album_description,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = Url::base();

if (isset($model->aImages[0]) && NULL != isset($model->aImages[0])) {
    $img = $model->aImages[0];
} else {
    $img = [];
    $img['url'] = '/frontend/web/images/';
    $img['filename'] = 'album_default';
    $img['ext'] = 'jpg';
}
//var_dump($language);
?>
<div class="albums-view">

    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-8">
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <!-- tracks -->
            <?php if ($model->active != 1): ?>
            <div class="alert-danger p-4">
            This is a deleted Album.
            </div>
            <?php endif ?>
            <div class="track_list mt15">

                <div class="media clearfix">
                  <div class="media-left">
                  <img class="media-object img-thumbnail" src="<?= $baseUrl.$img['url'].$img['filename'].'_400x400.'.$img['ext'] ?>" alt="<?= $model->album_name; ?>" width="350">
                  </div>
                  <div class="media-body">
                    <h3 class="media-heading"><?= $model->album_name; ?></h3>

                    <dl class="dl-horizontal">
                        <dt>Language:</dt>
                        <dd><?= isset($language[$model->language]) ? $language[$model->language] : 'Unknown'; ?></dd>
                        <dt>Type:</dt>
                        <dd><?= $model->type == 1 ? 'Single' : 'Album'; ?></dd>
                        <dt>First Release:</dt>
                        <dd><?= date('d-M-Y', strtotime($model->first_release_date)); ?></dd>
                        <dt>Created Time:</dt>
                        <dd><?= date('d-M-Y', strtotime($model->created_time)) ?></dd>
                        <dt>Genre:</dt>
                        <dd>
                            <?php 
                                if (isset($genres) && NULL != $genres) {
                                    foreach ($genres as $key => $value) {
                                        echo '<a href="'.$baseUrl.'/genre/index?id='.$key.'">'.$value.'</a>, ';
                                    }
                                }
                            ?>
                        </dd>
                        <dt>
                            Description:
                        </dt>
                    </dl>
                    <p><br><span class="small"><?= $model->album_description ?></span></p>
                    <p>
                    <?= Html::a(Yii::t('app', '<i class="far fa-edit"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= Html::a(Yii::t('app', '<i class="far fa-trash-alt"></i> Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-default btn-xs',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a(Yii::t('app', '<i class="fas fa-cloud-upload-alt"></i> Upload Music'), ['tracks/create', 'album_id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                </p>
                  </div>
                </div>

                <div class="table-responsive mt15">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Tracks In '<?= $model->album_name; ?>'</th>
                        <th></th>
                    </tr>
                    <?php if(isset($tracks)): ?>
                        <?php foreach($tracks as $key=> $value): ?>
                            <tr>
                                <td>
                                    <?= $key+1 ?>. <?= $value['name'] ?>
                                </td>
                                <td class="text-right">
                                    <?php if(isset($value['allSounds']) && NULL != $value['allSounds']): ?>
                                    <?php foreach($value['allSounds'] as $sounds): ?>
                                         &nbsp;
                                        
                                        <a href="<?= base64_encode(base64_encode($value['id'].'-'.$value['name'])); ?>" title="<?= $value['name'] ?>" data-trackid="<?= $value['id']?>" target="_blank" class="addtolist"><i class="fas fa-plus"></i></a> &nbsp;
                                        <a href="<?= base64_encode(base64_encode($value['id'].'-'.$value['name'])); ?>" title="<?= $value['name'] ?>" data-trackid="<?= $value['id']?>" target="_blank" class="songplaybtn"><span class="far fa-play-circle"></a> &nbsp;
                                        <a href="<?= $baseUrl.'/tracks/update?id='.$value['id'] ?>" title="Update" target="_blank"><i class="fas fa-pencil-alt"></i></a> &nbsp;
                                        <a href="<?= $baseUrl.'/tracks/delete?id='.$value['id'] ?>" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"><i class="fas fa-trash-alt"></i></span></a> &nbsp;
                                        
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                        <a href="<?= $baseUrl.'/tracks/update?id='.$value['id'] ?>" title="Upload Tracks" target="_blank"><span class="glyphicon glyphicon-cloud-upload"></span></a>  &nbsp;
                                        <a href="<?= $baseUrl.'/tracks/delete?id='.$value['id'] ?>" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"><i class="fas fa-trash-alt"></i></span></a> &nbsp;
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->render('/layouts/_player', ['userid' =>$userid]) ?>

