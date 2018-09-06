<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "userevent".
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
class Userevent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userevent';
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
     * @return UsereventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsereventQuery(get_called_class());
    }

    // public function getRelated()
    // {
    //     var_dump($this->type);

    //     if ($this->type == 'album') {
    //         return $this->hasOne(Albums::className(), ['id'=>'source_id']); //->viaTable('images', ['source_id'=>'id']);
    //     } elseif ($this->type == 'track') {
    //         return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
    //     } elseif ($this->type == 'like') {
    //         return $this->hasOne(Likes::className(), ['id'=>'source_id']);
    //     } elseif ($this->type == 'follow') {
    //         return $this->hasOne(Follow::className(), ['id'=>'source_id']);
    //     } else {
    //         return 0;
    //     }
        
    // }
    // public function getTheimages()
    // {

    //     if ($this->type == 'album') {
    //         return $this->hasOne(Images::className(), ['source_id'=>'source_id']);
    //     } elseif ($this->type == 'track') {
    //         //return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
    //         return [];
    //     } elseif ($this->type == 'like') {
    //         //return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
    //         return [];
    //     } elseif ($this->type == 'follow') {
    //         //return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
    //         return [];
    //     }

    // }
}
