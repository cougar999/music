<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "playlist".
 *
 * @property int $id
 * @property string $name
 * @property string $note
 * @property int $active
 * @property int $public
 * @property string $created_time
 * @property string $updated_time
 * @property int $created_user
 * @property int $updated_user
 */
class Playlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_time', 'updated_time', 'created_user', 'updated_user'], 'required'],
            [['active', 'public', 'created_user', 'updated_user'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['name', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'note' => Yii::t('app', 'Note'),
            'active' => Yii::t('app', 'Active'),
            'public' => Yii::t('app', 'Public'),
            'created_time' => Yii::t('app', 'Created Time'),
            'updated_time' => Yii::t('app', 'Updated Time'),
            'created_user' => Yii::t('app', 'Created User'),
            'updated_user' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return PlaylistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaylistQuery(get_called_class());
    }
}
