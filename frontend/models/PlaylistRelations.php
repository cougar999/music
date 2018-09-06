<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "playlist_relations".
 *
 * @property int $id
 * @property int $track_id This is the owner's id, maybe album_id or track_id
 * @property int $playlist_id
 * @property int $order
 * @property string $created_time
 */
class PlaylistRelations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlist_relations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['track_id', 'playlist_id', 'created_time'], 'required'],
            [['track_id', 'playlist_id', 'order'], 'integer'],
            [['created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'track_id' => Yii::t('app', 'Track ID'),
            'playlist_id' => Yii::t('app', 'Playlist ID'),
            'order' => Yii::t('app', 'Order'),
            'created_time' => Yii::t('app', 'Created Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return PlaylistRelationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaylistRelationsQuery(get_called_class());
    }


    public function getTracks()
    {
        return $this->hasOne(Tracks::className(), ['id'=>'track_id']);
    }
    public function getSounds()
    {
        return $this->hasOne(Sounds::className(), ['source_id'=>'track_id']);
    }
}
