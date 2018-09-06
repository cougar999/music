<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $filename
 * @property string $type
 * @property int $source_id
 * @property string $url
 * @property int $user_id
 */
class Images extends \yii\db\ActiveRecord
{
    public $avatar;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'type', 'source_id', 'url', 'user_id'], 'required'],
            [['source_id', 'user_id'], 'integer'],
            [['url'], 'string'],
            [['filename', 'type', 'ext'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'filename' => Yii::t('app', 'Filename'),
            'type' => Yii::t('app', 'Type'),
            'source_id' => Yii::t('app', 'Source ID'),
            'url' => Yii::t('app', 'Url'),
            'user_id' => Yii::t('app', 'User ID'),
            'ext' => Yii::t('app', 'EXT'),
        ];
    }

    /**
     * @inheritdoc
     * @return ImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImagesQuery(get_called_class());
    }
}
