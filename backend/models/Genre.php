<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property string $icon
 * @property int $active
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'active'], 'integer'],
            [['icon'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['active'], 'default', 'value'=> 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'order' => 'Order',
            'icon' => 'Icon',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return GenreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenreQuery(get_called_class());
    }
}
