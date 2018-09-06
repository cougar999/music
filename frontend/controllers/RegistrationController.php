<?php
namespace frontend\controllers;

use dektrium\user\Finder;
//use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\rbac\DbManager;
use frontend\models\Country;
use frontend\models\RegistrationForm;
use common\components\Helpers;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

class RegistrationController extends BaseRegistrationController
{
    public function behaviors()
    {
        return [
            
        ];
    }


    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);
        
        $helper = new Helpers;
        $country = $helper->getCountries();
        $city = $helper->getCities();

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        //var_dump(\Yii::$app->request->post());die();

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
        	
        	$roles = 'fans';

      		$post = \Yii::$app->request->post();

      		if (isset($post) && $post['register-form'] ) {
      			$roles = $post['register-form']['role'];
      		}


        	$userInfo = User::find()->where(['email' => $model->email])->one();

            $auth = new DbManager;
            $auth->init();
            $role = $auth->getRole($roles); //set default role to new registrations

            if(isset($role)) {
                \Yii::$app->authManager->assign($role, $userInfo->id);    
            } else {
                $role = $auth->createRole($roles);
                $auth->add($role);
                \Yii::$app->authManager->assign($role, $userInfo->id);
            }

            $this->trigger(self::EVENT_AFTER_REGISTER, $event);

            return $this->redirect(['//starter']);

            // return $this->render('/message', [
            //     'title'  => \Yii::t('user', 'Your account has been created'),
            //     'module' => $this->module,
            // ]);
        }
        
        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
            'country' => $country,
            'city' => $city
        ]);
    }

    public function actionGetcities()
    {
        $request = \Yii::$app->request->post();
        
        $country_id = $request['id'];
        $cities = Country::find()->where(['parent_id' => $country_id, 'location_type' => 1])->asArray()->all();
        $city = [];
        if ($cities) {
            foreach ($cities as $key => $value) {
                $city[] = $value;
            }
            echo $city ? json_encode($city) : 0;
        } else {
            echo 0;
        }   
    }

    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $user->attemptConfirmation($code);

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        return $this->render('//login/message', [
            'title'  => \Yii::t('user', 'Account confirmation'),
            'module' => $this->module,
        ]);
    }




}