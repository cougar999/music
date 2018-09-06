<?php

namespace frontend\models;

use dektrium\user\models\Profile;
use dektrium\user\Finder;
use dektrium\user\models\Token;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{

    public function getUserProfile($type = 'artist')
    {
        return $this->hasOne(User::className(), ['id'=>'id']);
    }

    public function getUserPhoto($type = 'avatar')
    {
        return $this->hasOne(Images::className(), ['source_id'=>'id']);
    }


}