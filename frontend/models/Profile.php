<?php

namespace frontend\models;

use dektrium\user\models\Profile as BaseProfile;
//use dektrium\user\models\User;

class Profile extends BaseProfile
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'bioString'            => ['bio', 'string'],
            'timeZoneValidation'   => ['timezone', 'validateTimeZone'],
            'publicEmailPattern'   => ['public_email', 'email'],
            'gravatarEmailPattern' => ['gravatar_email', 'email'],
            'websiteUrl'           => ['website', 'string'],
            'nameLength'           => ['name', 'string', 'max' => 255],
            'publicEmailLength'    => ['public_email', 'string', 'max' => 255],
            'gravatarEmailLength'  => ['gravatar_email', 'string', 'max' => 255],
            'locationLength'       => ['location', 'string', 'max' => 255],
            'websiteLength'        => ['website', 'string', 'max' => 255],
            
            'genderLength'        => ['gender', 'string', 'max' => 255],
            'birthdayLength'        => ['birthday', 'string', 'max' => 255],
            'countryLength'        => ['country', 'string', 'max' => 255],
            'cityLength'        => ['city', 'string', 'max' => 255],
            'facebookLength'        => ['facebook', 'string', 'max' => 255],
            'twitterLength'        => ['twitter', 'string', 'max' => 255],
            'youtubeLength'        => ['youtube', 'string', 'max' => 255],
            'linkedinLength'        => ['linkedin', 'string', 'max' => 255],
            'instagramLength'        => ['instagram', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Name'),
            'public_email'   => \Yii::t('user', 'Email (public)'),
            'gravatar_email' => \Yii::t('user', 'Gravatar email'),
            'location'       => \Yii::t('user', 'Location'),
            'website'        => \Yii::t('user', 'Website'),
            'bio'            => \Yii::t('user', 'Bio'),
            'timezone'       => \Yii::t('user', 'Time zone'),
            'gender'       => \Yii::t('user', 'Gender'),
            'birthday'       => \Yii::t('user', 'Birthday'),
            'city'       => \Yii::t('user', 'Area'),
            'facebook'       => \Yii::t('user', 'Facebook'),
            'twitter'       => \Yii::t('user', 'Twitter'),
            'youtube'       => \Yii::t('user', 'Youtube'),
            'linkedin'       => \Yii::t('user', 'LinkedIn'),
            'instagram'       => \Yii::t('user', 'Instagram'),
        ];
    }

}