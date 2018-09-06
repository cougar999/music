<?php
namespace frontend\models;

use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\data\Pagination;
use johnnylei\message_system\Message;
use yii\base\Component;
use yii\base\Exception;
use Yii;

use johnnylei\message_system\BaseRecord;
use johnnylei\message_system\MessageUserMap;
use johnnylei\message_system\MessageQueueSubscription;

use johnnylei\message_system\MessageManager as BaseMessageManager;

class MessageManager extends BaseMessageManager
{
    public function getNewMessageCount() {
    	$query = Message::find()->select([
            't1.*',
            't2.checked',
            't2.checked_time',
            't2.id primary_id'
        ])->alias('t1')
            ->leftJoin(BaseRecord::MessageUserMap . ' t2', 't1.id = t2.message_id')
            ->andWhere([
                'and',
                ['t2.user_id'=>Yii::$app->getUser()->getId()],
                ['t2.checked'=>MessageUserMap::UnChecked]
            ]);
        return $query->orderBy(['t1.id'=>SORT_DESC])->asArray()->count();
	}
}

