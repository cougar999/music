<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'frontend/web/lib/MDB/css/mdb.css',
        'frontend/web/lib/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css',
        'css/site.css',
        
    ];
    public $js = [
        //'frontend/web/lib/fontawesome/svg-with-js/js/fontawesome-all.min.js',
        'frontend/web/lib/MDB/js/mdb.js',
        'frontend/web/js/actions.js?ver20180705',
        'frontend/web/js/app.js?ver20180705',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}
