<?php
namespace common\components;
use Yii;
use frontend\models\Country;
use frontend\models\Likes;
use frontend\models\Follow;
use frontend\models\Counter;
use frontend\models\Images;
use frontend\models\GenreBelongs;
use yii\helpers\Url;

use johnnylei\message_system\Message;
use frontend\models\MessageManager;
use johnnylei\message_system\MessageQueueSubscription;
use frontend\models\Userevent;

class Helpers {

    public function getCountries()
    {
    	$countries = Country::find()->andWhere('location_type= :location_type', [':location_type' => 0])->asArray()->all();

        $country = [];

        if (isset($countries)) {
            foreach ($countries as $key => $value) {
                $country[$value['id']] = $value['name'];
            }
        }
        return $country;
    }

    public function getCities()
    {
        $cities = Country::find()->where(['location_type' => 1])->asArray()->all();
        $city = [];

        if (isset($cities)) {
            foreach ($cities as $k => $v) {
                $city[$v['id']] = $v['name'];
            }
        }
        return $city;
    }

    public function like($sourceid, $cate)
    {
    	$time = Date("Y-m-d H:i:s");
    	$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

    	if (!$sourceid || !$cate || !$userid) {
    		return;
    	}

		$like = Likes::find()->where(['source_id' => $sourceid, 'created_user' => $userid, 'type' => $cate])->orderBy('id DESC')->one();

		if (isset($like) && NULL != $like) {
			if ($like->active == 1) {
				$like->active = 0;
			} else {
				$like->active = 1;
			}
			$like->updated_time = $time;
			$like->updated_user = $userid;
			if ($like->save()) {
				if ($like->active == 1) {
					$counter = $this->setCounter($sourceid, 'like', $cate, 'SUM'); // ++
				} else {
					$counter = $this->setCounter($sourceid, 'like', $cate, 'SUB'); // --
				}
				if (isset($counter)) {
					return $like;
				};
				
			} else {
				return $like->getErrors();
			}
		} else {
			$like1 = new Likes;
			$like1->source_id = $sourceid;
			$like1->created_user = $userid;
			$like1->updated_user = $userid;
			$like1->type = $cate;
			$like1->active = 1;
			$like1->created_time = $time;
			$like1->updated_time = $time;

			if ($like1->save()) {
				$counter = $this->setCounter($sourceid, 'like', $cate, 'SUM');

				$this->sendMessage('You have A new Like.', 'Hi Dear artist, you have a New Like', $sourceid, $userid);
                // add an event for user status
                $event = $this->userEvent($like1->id, 'like');

				if (isset($counter)) {
					return $like1;
				};
			} else {
				return $like1->getErrors();
			}
		}

    }

    public function follow($sourceid, $cate)
    {
    	$time = Date("Y-m-d H:i:s");
    	$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

    	if (!$sourceid || !$cate || !$userid) {
    		return;
    	}

		$follow = Follow::find()->where(['source_id' => $sourceid, 'created_user' => $userid, 'type' => $cate])->orderBy('id DESC')->one();

		if (isset($follow) && NULL != $follow) {
			if ($follow->active == 1) {
				$follow->active = 0;
			} else {
				$follow->active = 1;
			}
			$follow->updated_time = $time;
			$follow->updated_user = $userid;
			if ($follow->save()) {
				if ($follow->active == 1) {
					$counter = $this->setCounter($sourceid, 'follow', $cate, 'SUM'); // ++
				} else {
					$counter = $this->setCounter($sourceid, 'follow', $cate, 'SUB'); // --
				}
				if (isset($counter)) {
					return $follow;
				};
				
			} else {
				return $follow->getErrors();
			}
		} else {
			$follow1 = new Follow;
			$follow1->source_id = $sourceid;
			$follow1->created_user = $userid;
			$follow1->updated_user = $userid;
			$follow1->type = $cate;
			$follow1->active = 1;
			$follow1->created_time = $time;
			$follow1->updated_time = $time;

			if ($follow1->save()) {
				$counter = $this->setCounter($sourceid, 'follow', $cate, 'SUM');

				$this->sendMessage('You have A new Follower.', 'Hi Dear artist, you have a New Follower', $sourceid, $userid);
                // add an event for user status
                $event = $this->userEvent($follow1->id, 'follow');

				if (isset($counter)) {
					return $follow1;
				};
			} else {
				return $follow1->getErrors();
			}
		}

    }

    public function setCounter($sourceid, $type, $cate, $action)
    {
    	$time = Date("Y-m-d H:i:s");
    	$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

    	if (!$sourceid || !$cate || !$userid || !$type) {
    		return 0;
    	}
    	$counter = Counter::find()->where(['source_id' => $sourceid, 'cate' => $cate, 'type' => $type])->one();
    	if (isset($counter) && NULL != $counter) {
    		if ($action && $action == 'SUM') {
    			$counter->count = $counter->count + 1;
    		} else {
    			$counter->count = $counter->count - 1;
    		}
    		$counter->updated_time = $time;
    		$counter->updated_user = $userid;
    		if ($counter->save()) {
    			return $counter;
    		} else {
				return $counter->getErrors();
			}

    	} else {
    		$counter = new Counter;	
    		$counter->source_id = $sourceid;
    		$counter->count = 1;
    		$counter->type = $type;
    		$counter->cate = $cate;
			$counter->active = 1;
    		$counter->updated_time = $time;
    		$counter->updated_user = $userid;
			$counter->created_user = $userid;
			$counter->created_time = $time;
    		if ($counter->save()) {
    			return $counter;
    		} else {
				return $counter->getErrors();
			}
    	}
    	
    }

    public function getAvatar()
    {
    	$weburl = Url::to("@web");
    	if (isset(Yii::$app->user) && isset(Yii::$app->user->identity->id)) {
    		$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;
	    	$photo = Images::find()->where(['user_id' => $userid, 'source_id' => $userid, 'type' => 'avatar'])->orderBy('id DESC')->one();
	    	if (isset($photo)) {
	    		
	    		//$uploadpath = Yii::$app->params['uploadPath'];
	    		$path = $weburl.$photo->url.$photo->filename.'.'.$photo->ext;
	    		return $path;
	    	} else {
	    		return $weburl.'/frontend/web/images/avatar_default2.jpg';
	    	}
    	} else {
    		return $weburl.'/frontend/web/images/avatar_default2.jpg';
    	}
    	
    }

    public function sendMessage($title, $body, $receiver, $producer)
    {
    	//send a message to the owner
		$queue_id = 'user-'.$receiver;
		$subscription = new MessageQueueSubscription();
		
		$subscriber = $subscription->getSubscriber($queue_id);
		//var_dump($receiver, $subscription, $subscriber);
		
		if (!isset($subscriber) || NULL == $subscriber || !in_array($receiver, $subscriber)) {
			$subscription->subscription($queue_id, $receiver);
		}
		
		$sender = new MessageManager;
		$result = $sender->send([
            'title'=> $title,
            'body'=> $body,
            'type'=> 1,
            //'show_style'=>'',
            'producer' => $producer,
            'queue_id' => $queue_id
        ], $queue_id, true, $producer);

    	return $result;

    }

    public function readMessage($msgid)
    {
    	$time = Date("Y-m-d H:i:s");
    	$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

    	if (!$msgid|| !$userid) {
    		return;
    	}

    	$message = new MessageManager;
    	$result = $message->checkMessage($msgid);

    	return $result;

    }

    public function removeMessage($msgid)
    {
    	$time = Date("Y-m-d H:i:s");
    	$userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

    	if (!$msgid|| !$userid) {
    		return;
    	}

    	$message = new MessageManager;
    	$result = $message->deleteMessage($msgid);
    	
    	return $result;

    }

    public function getMessageCount(){
    	$message = new MessageManager;
    	$result = $message->getNewMessageCount();
    	if (isset($result) && count($result) > 0) {
    		return $result;
    	}
    }

    public function clearAblums($album_id)
    {
        if (!$album_id) return 0;
        
        $genre_belongs = GenreBelongs::find()->where(['owner_id' => $album_id, 'type' => 'album'])->all();
        if (isset($genre_belongs) && count($genre_belongs) > 0) {

            foreach ($genre_belongs as $key => $value) {
                $value->active = 0;
                $value->update();
            }
        }

        $counts = Counter::find()->where(['cate' => 'album', 'type' => 'like', 'active' => 1])->all();
        if (isset($counts) && count($counts) > 0) {

            foreach ($counts as $key => $value) {
                $value->active = 0;
                $value->update();
            }
        }

        $tracks = Tracks::find()->where(['album_id' => $album_id, 'active' => 1])->all();
        if (isset($tracks) && count($tracks) > 0) {

            foreach ($tracks as $key => $value) {
                $value->active = 0;
                $value->update();
            }
        }

        $likes = Likes::find()->where(['source_id' => $album_id, 'active' => 1])->all();
        if (isset($likes) && count($likes) > 0) {

            foreach ($tracks as $key => $value) {
                $value->active = 0;
                $value->update();
            }
        }

    }

    // pass a yii2 model to return a track link 
    public function getSongUrls($model)
    {
        if (!$model || !count($model) > 0 || NULL == $model) return 0;
        $url = $model->url . $model->filename . '.' . $model->ext;
        return $url;

    }

    public function userEvent($sourceid, $type)
    {
        if (!$sourceid || !$type) {
            return;
        }
        $time = Date("Y-m-d H:i:s");
        $userid = Yii::$app->user->identity->id ? Yii::$app->user->identity->id : 0;

        $event = new Userevent;
        $event->source_id = $sourceid;
        $event->type = $type;
        $event->created_time = $time;
        $event->created_user = $userid;
        $event->updated_time = $time;
        $event->updated_user = $userid;
        
        if ($event->save()) {
            return 1;
        } else {
            var_dump($event->getErrors());die();
        }

        return 0;

    }

}
?>