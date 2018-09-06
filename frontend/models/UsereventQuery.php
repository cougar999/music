<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Userevent]].
 *
 * @see Userevent
 */
class UsereventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Userevent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Userevent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
