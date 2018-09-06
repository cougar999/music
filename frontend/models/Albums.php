<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "albums".
 *
 * @property int $id
 * @property string $album_name
 * @property string $album_description
 * @property string $language
 * @property string $cover
 * @property int $type
 * @property int $active
 * @property string $first_release_date
 * @property string $created_time
 * @property string $updated_time
 * @property int $created_user
 * @property int $updated_user
 */
class Albums extends \yii\db\ActiveRecord
{
    public $genre;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_name', 'created_time', 'updated_time', 'created_user', 'updated_user'], 'required'],
            [['album_description', 'cover'], 'string'],
            [['type', 'active', 'created_user', 'updated_user'], 'integer'],
            [['first_release_date', 'created_time', 'updated_time'], 'safe'],
            [['album_name', 'language'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'album_name' => Yii::t('app', 'Album Name'),
            'album_description' => Yii::t('app', 'Album Description'),
            'language' => Yii::t('app', 'Language'),
            'cover' => Yii::t('app', 'Cover'),
            'type' => Yii::t('app', 'Type'),
            'active' => Yii::t('app', 'Active'),
            'first_release_date' => Yii::t('app', 'First Release Date'),
            'created_time' => Yii::t('app', 'Created Time'),
            'updated_time' => Yii::t('app', 'Updated Time'),
            'created_user' => Yii::t('app', 'Created User'),
            'updated_user' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return AlbumsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlbumsQuery(get_called_class());
    }

    public function getAImages($type = 'album')
    {
        //客户和订单是一对多的关系所以用hasMany
        //此处OrdersModel在CustomerModel顶部别忘了加对应的命名空间
        //id对应的是OrdersModel的id字段，order_id对应CustomerModel的order_id字段
        return $this->hasMany(Images::className(), ['source_id'=>'id'])->where(['type' => $type]);
    }
}
