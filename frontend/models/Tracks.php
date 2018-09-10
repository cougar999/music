<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tracks".
 *
 * @property int $id
 * @property int $album_id
 * @property string $name
 * @property string $cover
 * @property string $url
 * @property string $artist_id
 * @property string $lyricist
 * @property string $composer
 * @property string $arrangement
 * @property string $lyrics
 * @property int $active
 * @property string $created_time
 * @property string $updated_time
 * @property int $created_user
 * @property int $updated_user
 */
class Tracks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tracks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'active', 'created_user', 'updated_user'], 'integer'],
            [['name', 'created_time', 'updated_time', 'created_user', 'updated_user'], 'required'],
            [['cover', 'url', 'lyrics'], 'string'],
            [['created_time', 'updated_time'], 'safe'],
            [['name', 'artist_id', 'lyricist', 'composer', 'arrangement'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'album_id' => Yii::t('app', 'Album ID'),
            'name' => Yii::t('app', 'Name'),
            'cover' => Yii::t('app', 'Cover'),
            'url' => Yii::t('app', 'Track Source'),
            'artist_id' => Yii::t('app', 'Artist'),
            'lyricist' => Yii::t('app', 'Lyricist'),
            'composer' => Yii::t('app', 'Composer'),
            'arrangement' => Yii::t('app', 'Arrangement'),
            'lyrics' => Yii::t('app', 'Lyrics'),
            'active' => Yii::t('app', 'Active'),
            'created_time' => Yii::t('app', 'Created Time'),
            'updated_time' => Yii::t('app', 'Updated Time'),
            'created_user' => Yii::t('app', 'Created User'),
            'updated_user' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return TracksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TracksQuery(get_called_class());
    }

    public function getAImages($type = 'tracks')
    {
        return $this->hasMany(Images::className(), ['source_id'=>'id'])->where(['type' => $type]);
    }

    public function getAllSounds($type = 'tracks')
    {
        return $this->hasMany(Sounds::className(), ['source_id'=>'id'])->where(['type' => $type]);
    }

    public function getClicks($type = 'like')
    {
        return $this->hasOne(Counter::className(), ['source_id'=>'id'])->where(['type' => $type, 'cate' => 'track']);
    }

    public function getUserProfile()
    {
        return $this->hasOne(User::className(), ['id'=>'source_id']);
    }

}
