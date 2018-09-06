<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "counter".
 *
 * @property int $id
 * @property int $source_id
 * @property string $type like or follow
 * @property string $cate album, track, or something else
 * @property int $count
 * @property int $active
 * @property string $created_time
 * @property string $updated_time
 * @property int $created_user
 * @property int $updated_user
 */
class Counter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'counter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'count', 'active', 'created_user', 'updated_user'], 'integer'],
            [['type', 'cate', 'created_time', 'updated_time', 'created_user', 'updated_user'], 'required'],
            [['created_time', 'updated_time'], 'safe'],
            [['type', 'cate'], 'string', 'max' => 255],
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
            'cate' => Yii::t('app', 'Cate'),
            'count' => Yii::t('app', 'Count'),
            'active' => Yii::t('app', 'Active'),
            'created_time' => Yii::t('app', 'Created Time'),
            'updated_time' => Yii::t('app', 'Updated Time'),
            'created_user' => Yii::t('app', 'Created User'),
            'updated_user' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return CounterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CounterQuery(get_called_class());
    }

    public function getTracks()
    {
        //客户和订单是一对多的关系所以用hasMany
        //此处OrdersModel在CustomerModel顶部别忘了加对应的命名空间
        //id对应的是OrdersModel的id字段，order_id对应CustomerModel的order_id字段
        return $this->hasOne(Tracks::className(), ['id'=>'source_id']);
    }
}
