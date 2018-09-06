<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[GenreBelongs]].
 *
 * @see GenreBelongs
 */
class GenreBelongsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GenreBelongs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GenreBelongs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
