<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[PlaylistRelations]].
 *
 * @see PlaylistRelations
 */
class PlaylistRelationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PlaylistRelations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PlaylistRelations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
