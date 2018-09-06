<?php

namespace frontend\models;

use Yii;
use frontend\models\Counter;

/**
 * This is the model class for table "likes".
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
class Likes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes';
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
     * @return LikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikesQuery(get_called_class());
    }

    public function getLikesAlbum()
    {
            return $this->hasOne(Albums::className(), ['id'=>'source_id']);
        
    }
    public function getLikesTrack()
    {
            return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
        
    }

    /*public function getUserLikes()
    {
        return $this->hasMany(Counter::className(), ['id'=>'source_id'])->where(['type' => 'like', 'cate' => 'album', 'active' => 1])->orderBy('count DESC');

    }*/

}
