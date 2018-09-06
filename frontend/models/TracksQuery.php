<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Tracks]].
 *
 * @see Tracks
 */
class TracksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Tracks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tracks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
