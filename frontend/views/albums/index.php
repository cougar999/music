<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AlbumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Albums');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="albums-index">
    <div class="row">
        <div class="col-md-2 col-sm-12 col-lg-2">
            <?= $this->render('/layouts/_common_left_menu') ?>
        </div>
        <div class="col-md-10 col-sm-12 col-lg-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('app', 'Create Albums'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            
            <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => [
                    'class' => 'item'
                ],
                'itemView' => '_item_list',
                'viewParams' => [
                    'baseurl' => Url::home()
                ],
            ]) ?>
            </div>
        </div>
</div>