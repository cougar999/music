<?php

use yii\helpers\Html;
//use common\components\Helpers;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Playlist */
//$helper = new Helpers;
$baseUrl = Url::base();

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Playlists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlist-view">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
        <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', '<i class="fas fa-pencil-alt"></i> Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', '<i class="fas fa-trash-alt"></i> Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Create a new Playlist'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        <table class="table table-hover">

            <!--Table head-->
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Tracks</th>
                    <th width="200"></th>
                </tr>
            </thead>
            <!--Table head-->

            <!--Table body-->
            <tbody>
                <?php if (isset($tracks) && count($tracks) > 0): ?>
                <?php foreach ($tracks as $key => $value): ?>
                    <?php if (isset($value['tracks']) && $value['tracks']->id > 0): ?>
                    <tr>
                        <th><?= $key+1 ?></th>
                        <td><a href="<?= base64_encode(base64_encode($value['tracks']->id.'-'.$value['tracks']->name)); ?>" title="<?= $value['tracks']->name ?>" data-trackid="<?= $value['tracks']->id ?>" target="_blank" class="songplaybtn d-block"><?= $value['tracks']->name ?></a></td>
                        <td class="text-right pr-5">
                            <!-- play -->
                            <a href="<?= base64_encode(base64_encode($value['tracks']->id.'-'.$value['tracks']->name)); ?>" title="<?= $value['tracks']->name ?>" data-trackid="<?= $value['tracks']->id ?>" target="_blank" class="songplaybtn"><i class="far fa-play-circle"></i></a> &nbsp;&nbsp;

                            <!-- album link -->
                            <a href="<?= $baseUrl?>/site/album-view?id=<?= $value['tracks']->album_id ?>" title="view the album"><i class="fas fa-images"></i></a> &nbsp;&nbsp;

                            <!-- remove -->
                            <a href="<?= $baseUrl?>/playlist-relations/delete?id=<?= $value->id ?>&playlist=<?= $model->id ?>" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"><i class="fas fa-trash-alt"></i></a>

                        </td>
                    </tr>
                    <?php endif ?>
                <?php endforeach ?>
                <?php endif ?>
                
            </tbody>
            <!--Table body-->

        </table>
        <?php if (!isset($tracks) || !count($tracks) > 0): ?>
            <div class="">
                <a class="btn btn-blue-grey btn-lg btn-block" href="<?= $baseUrl ?>/starter/index">Nothing in this playlist? Try our recommendation.</a>
            </div>
        <?php else: ?>
            <div class="">
                <a class="btn btn-blue-grey btn-lg btn-block" href="<?= $baseUrl ?>/starter/index"><i class="fas fa-headphones"></i> Find more Songs</a>
            </div>
        <?php endif ?>
        </div>
        
    </div>
</div>

<?= $this->render('/layouts/_player', ['userid' =>$userid]) ?>