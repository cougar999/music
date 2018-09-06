<?php
namespace frontend\controllers;

use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\LoginForm;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;



use dektrium\user\controllers\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {

        	if (\Yii::$app->user->can('Administrator')) {
                $this->trigger(self::EVENT_AFTER_LOGIN, $event);
                return $this->goBack();
            }
            else if (\Yii::$app->user->can('artist')) {
                return $this->redirect(['/artist/index']);
            }
            else if (\Yii::$app->user->can('fans')) {
                return $this->redirect(['/fans/index']);
            }
            else if (\Yii::$app->user->can('producer')) {
                return $this->redirect(['/producer/index']);
            }

            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}