<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "genre_likes".
 *
 * @property int $id
 * @property int $owner_user_id This is the owner's id, maybe album_id or track_id
 * @property int $genre_id
 * @property string $type album or track
 * @property int $order
 * @property int $active
 */
class GenreLikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre_likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_user_id', 'type'], 'required'],
            [['owner_user_id', 'genre_id', 'order', 'active'], 'integer'],
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
            'owner_user_id' => Yii::t('app', 'Owner User ID'),
            'genre_id' => Yii::t('app', 'Genre ID'),
            'type' => Yii::t('app', 'Type'),
            'order' => Yii::t('app', 'Order'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @inheritdoc
     * @return GenreLikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenreLikesQuery(get_called_class());
    }
}
