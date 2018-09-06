<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[GenreLikes]].
 *
 * @see GenreLikes
 */
class GenreLikesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GenreLikes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GenreLikes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
