<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "genre_belongs".
 *
 * @property int $id
 * @property int $owner_id This is the owner's id, maybe album_id or track_id
 * @property int $genre_id
 * @property string $type album or track
 * @property int $order
 * @property int $active
 */
class GenreBelongs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre_belongs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'type'], 'required'],
            [['owner_id', 'genre_id', 'order', 'active'], 'integer'],
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
            'owner_id' => Yii::t('app', 'Owner ID'),
            'genre_id' => Yii::t('app', 'Genre ID'),
            'type' => Yii::t('app', 'Type'),
            'order' => Yii::t('app', 'Order'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @inheritdoc
     * @return GenreBelongsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenreBelongsQuery(get_called_class());
    }

    public function getGenreNames()
    {
        return $this->hasMany(Genre::className(), ['id'=>'genre_id']);
    }
}
