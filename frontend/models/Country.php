<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property int $location_type 0:country,1:state,2:city
 * @property int $parent_id parent location_id
 * @property int $is_visible 0:visible,1:invisible
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'location_type', 'parent_id', 'is_visible'], 'required'],
            [['location_type', 'parent_id', 'is_visible'], 'integer'],
            [['name'], 'string', 'max' => 30],
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
            'location_type' => Yii::t('app', 'Location Type'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'is_visible' => Yii::t('app', 'Is Visible'),
        ];
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
