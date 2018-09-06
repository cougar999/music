<?php
namespace common\components;
use Yii;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
//use yii\web\ForbiddenHttpException;
use yii\web\HttpException;


class AccessAuth {

    public function belong($model)
    {
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
        $owner = $model->created_user ? $model->created_user : null;
        if ($userid != $model->created_user) {
            //throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this property.'));
            throw new \yii\web\HttpException(403, 'You are not allowed to access this property.');
        }
    }

}
?>