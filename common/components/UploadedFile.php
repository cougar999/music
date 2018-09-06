<?php
namespace common\components;

use yii\helpers\Url;
use yii\helpers\BaseUrl;
use frontend\models\Images;
use frontend\models\Sounds;
use yii\imagine\Image;


class UploadedFile extends \yii\web\UploadedFile {

    public function UploadImage($model, $name, $type, $action = 'create')
    {
        $userid = \Yii::$app->user->identity->id ? \Yii::$app->user->identity->id : 0;

        // the path to save file, you can set an user folder by user id
        $user_folder = \Yii::$app->basePath . '/web/uploads/'.$userid.'/';

        if (!is_dir($user_folder)) {
            mkdir($user_folder);         
        }

        // in Yii::$app->params (as used in example below)                       
        //\Yii::$app->params['uploadPath'] = $user_folder . $type. '_'.$model->id.'/';
        $uploadFolder = $user_folder . $type. '_'.$model->id.'/';

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder);         
        }

        //delete cover image when a hidden input set to delete or update
        if (isset($action) && ($action == 'delete' || $action == 'update')) {
            //delete previous cover
            $result = $this->DeleteImage($model, $type, $userid);
        }

        $image = UploadedFile::getInstance($model, $name);

        if (!is_null($image)) {

            $ext = end((explode(".", $image->name)));
            // generate a unique file name to prevent duplicate filenames
            $filename_short = \Yii::$app->security->generateRandomString();
            $model->$name = $filename = $filename_short.".{$ext}";

            //$path = \Yii::$app->params['uploadPath'] . $model->$name;
            $path = $uploadFolder . $model->$name;

            $image->saveAs($path);

            Image::thumbnail($path, 400, 400)->save($uploadFolder.$filename_short.'_400x400.'.$ext, ['quality' => 60]);

            $xsave = new Images;
            $xsave->user_id = $userid;
            $xsave->type = $type;
            $xsave->filename = $filename_short;
            $xsave->url = \Yii::$app->params['uploadPath'].$userid.'/'.$type.'_'. $model->id.'/';
            $xsave->user_id = $userid;
            $xsave->source_id = $model->id;
            $xsave->ext = $ext;

            if($xsave->save()) {
                return true;
            } else {
                return false;
            }


        } else {
            return false;
        }

    }


    public function DeleteImage($model, $type, $userid)
    {
        $image = Images::find()->where(['source_id' => $model->id, 'user_id' => $userid, 'type' => $type])->orderBy('id DESC')->one();

        if (isset($image)) {

            $user_folder = \Yii::$app->basePath . '/web/uploads/'.$userid.'/' . $image->type .'_'.$image->source_id .'/';

            $path = $user_folder . $image->filename .'.'.$image->ext;
            
            /*$thumbnail = explode('.', $image->filename);
            $thumbnail_name = $thumbnail[0].'_400x400.'.$thumbnail[1];
            $thumbnail_name = $thumbnail[0].'_400x400.'.$thumbnail[1];*/

            $thumbnail_name = $image->filename . '_400x400.' .$image->ext;

            $thumbnail_file =  $user_folder . $thumbnail_name;
            
            $image->delete();

            if (file_exists($path) || file_exists($thumbnail_file)){
                if (unlink($path) && unlink($thumbnail_file)) {
                    return true;
                } else {
                    var_dump(123);die();
                    return false;    
                }  
            }

        }
    }


// upload and delete tracks

    public function UploadTracks($model, $name, $type, $action = 'create')
    {
        $userid = \Yii::$app->user->identity->id ? \Yii::$app->user->identity->id : 0;

        // the path to save file, you can set an user folder by user id
        $user_folder = \Yii::$app->basePath . '/web/uploads/'.$userid.'/';

        if (!is_dir($user_folder)) {
            mkdir($user_folder);         
        }

        // in Yii::$app->params (as used in example below)                       
        //\Yii::$app->params['uploadPath'] = $user_folder . $type. '_'.$model->id.'/';
        $uploadFolder = $user_folder . $type. '_'.$model->id.'/';

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder);         
        }

        //delete cover image when a hidden input set to delete or update
        if (isset($action) && ($action == 'delete' || $action == 'update')) {
            //delete previous cover
            $result = $this->DeleteTrack($model, $type, $userid);
        }

        $tracks = UploadedFile::getInstance($model, $name);

        if (!is_null($tracks)) {

            $ext_s = explode(".", $tracks->name);
            $ext = end($ext_s);
            // generate a unique file name to prevent duplicate filenames
            $filename_short = \Yii::$app->security->generateRandomString();
            $model->$name = $filename = $filename_short.".{$ext}";

            //$path = \Yii::$app->params['uploadPath'] . $model->$name;
            $path = $uploadFolder . $model->$name;

            $tracks->saveAs($path);

            $xsave = new Sounds;
            $xsave->user_id = $userid;
            $xsave->type = $type;
            $xsave->filename = $filename_short;
            $xsave->url = \Yii::$app->params['uploadPath'].$userid.'/'.$type.'_'. $model->id.'/';
            $xsave->user_id = $userid;
            $xsave->source_id = $model->id;
            $xsave->ext = $ext;

            if($xsave->save()) {
                return true;
            }

        }
    }

    public function DeleteTrack($model, $type, $userid)
    {
        $track = Sounds::find()->where(['source_id' => $model->id, 'user_id' => $userid, 'type' => $type])->orderBy('id DESC')->one();
        if (isset($track)) {

            $user_folder = \Yii::$app->basePath . '/web/uploads/'.$userid.'/' . $track->type .'_'.$track->source_id .'/';

            $path = $user_folder . $track->filename .'.'.$track->ext;
            

            $track->delete();

            if (file_exists($path)){
                if (unlink($path)) {   
                    return "delete file success";
                } else {
                    return "delete file fail";    
                }  
            }

        }
    }

    /* have not use, need to fix or improve
    public function UploadAvatar($model, $type, $params, $action = 'create')
    {
        $userid = \Yii::$app->user->identity->id ? \Yii::$app->user->identity->id : 0;

        // the path to save file, you can set an user folder by user id
        $user_folder = \Yii::$app->basePath . '/web/uploads/'.$userid.'/';

        if (!is_dir($user_folder)) {
            mkdir($user_folder);         
        }

        $uploadFolder = $user_folder . $type;

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder);         
        }
        if (isset($action) && ($action == 'delete' || $action == 'update')) {
            //delete previous cover
            $result = $this->DeleteAvartar($type, $userid);
        }
        
        $image = UploadedFile::getInstance($model, $type);
       var_dump($image, $model, $type);die();

        if (!is_null($image)) {

            $ext = end((explode(".", $image->name)));
            $filename_short = \Yii::$app->security->generateRandomString();
            $filename = $filename_short.".{$ext}";

            $path = $uploadFolder.'/'.$filename;
            $image->saveAs($path);


            //Image::thumbnail($path, 400, 400)->save($uploadFolder.$filename_short.'_400x400.'.$ext, ['quality' => 60]);
            Image::crop($path, $params['w'], $params['h'], [$params['x'], $params['y']])->save($uploadFolder.'/'.$filename_short.'.'.$ext, ['quality' => 60]);

            $xsave = new Images;
            $xsave->user_id = $userid;
            $xsave->type = 'avatar';
            $xsave->filename = $filename_short;
            $xsave->url = \Yii::$app->params['uploadPath'].$userid.'/'.$type;
            $xsave->user_id = $userid;
            $xsave->source_id = $userid;
            $xsave->ext = $ext;

            if($xsave->save()) {
                return true;
            } 

        } else {
            return false;
        }


    }*/

}
?>