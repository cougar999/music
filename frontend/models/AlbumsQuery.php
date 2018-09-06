<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Albums]].
 *
 * @see Albums
 */
class AlbumsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Albums[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Albums|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
