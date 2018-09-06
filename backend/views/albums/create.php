<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Albums */

$this->title = Yii::t('app', 'Create Albums');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="albums-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
