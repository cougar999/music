<?php

namespace frontend\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
//use dektrium\user\models\User;

class RegistrationForm extends BaseRegistrationForm
{

    /**
     * Add a new field
     * @var string
     */
    public $country;
    public $city;
    public $gender;
    public $birthday;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['country', 'trim'];
        $rules[] = ['country', 'required'];
        $rules[] = ['country', 'string', 'max' => 255];

        $rules[] = ['city', 'trim'];
        $rules[] = ['city', 'required'];
        $rules[] = ['city', 'string', 'max' => 255];

        $rules[] = ['birthday', 'required'];
        $rules[] = ['birthday', 'string', 'max' => 255];

        $rules[] = ['gender', 'required'];
        $rules[] = ['gender', 'string', 'max' => 255];

        $rules[] = ['role', 'required', 'message' => 'You must choose a role.'];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['country'] = \Yii::t('country', 'Country');
        $labels['city'] = \Yii::t('city', 'Area');
        $labels['birthday'] = \Yii::t('birthday', 'Birthday');
        $labels['gender'] = \Yii::t('gender', 'Gender');
        $labels['role'] = \Yii::t('role', 'Role');
        // $labels['country'] = 'Country';
        // $labels['birthday'] = 'Birthday';
        // $labels['gender'] = 'Gender';
        return $labels;

    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(\dektrium\user\models\User $user)
    {

        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ]);

        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());

        $profile->setAttributes([
            'country'    => $this->country,
            'city'    => $this->city,
            'birthday' => date("Y-m-d", strtotime($this->birthday)),
            'gender' => $this->gender,
        ]);

        //var_dump($profile, $profile->loadAttributes());die;

        $user->setProfile($profile);
    }

    public function register()
    {

        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = \Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }


        /////////////////////////
        ////todo need to do some changes, like redirecting to the homepage or login page.
        ////////////////////////

        \Yii::$app->session->setFlash(
            'info',
            \Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );

        return true;
    }

    

}