<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Follow]].
 *
 * @see Follow
 */
class FollowQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Follow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Follow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
