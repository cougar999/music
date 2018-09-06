<?php

namespace frontend\models;
//use dektrium\user\models\User;
use frontend\models\Images;

use Yii;

/**
 * This is the model class for table "follow".
 *
 * @property int $id
 * @property int $source_id
 * @property string $type
 * @property int $active
 * @property string $created_time
 * @property string $updated_time
 * @property int $created_user
 * @property int $updated_user
 */
class Follow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'active', 'created_user', 'updated_user'], 'integer'],
            [['type', 'created_time', 'updated_time', 'created_user', 'updated_user'], 'required'],
            [['created_time', 'updated_time'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'source_id' => Yii::t('app', 'Source ID'),
            'type' => Yii::t('app', 'Type'),
            'active' => Yii::t('app', 'Active'),
            'created_time' => Yii::t('app', 'Created Time'),
            'updated_time' => Yii::t('app', 'Updated Time'),
            'created_user' => Yii::t('app', 'Created User'),
            'updated_user' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return FollowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FollowQuery(get_called_class());
    }

    public function getUserProfile($type = 'artist')
    {
        return $this->hasOne(User::className(), ['id'=>'source_id']);
    }

    public function getUserPhoto($type = 'avatar')
    {
        return $this->hasOne(Images::className(), ['source_id'=>'source_id']);
    }

    public function getAlbumsCount()
    {
        return $this->hasMany(Albums::className(), ['created_user' => 'source_id'])->count();
    }

}
