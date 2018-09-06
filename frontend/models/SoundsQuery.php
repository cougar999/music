<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Sounds]].
 *
 * @see Sounds
 */
class SoundsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Sounds[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Sounds|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
