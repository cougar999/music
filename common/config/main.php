<?php
return [
    'name' => 'VERT SOUND',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Australia/Melbourne',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views/registration' => '@frontend/views/registration',
                    '@dektrium/user/views/security' => '@frontend/views/login',
                    '@dektrium/user/views/settings' => '@frontend/views/site',
                    //'@dektrium/user/views/message' => '@frontend/views/login/message',
                ],
            ],
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'js' => ['js/bootstrap.js'],
                ],
            ],
        ],

    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                //'admin' => 'frontend\controllers\AdminController',
                'registration' => 'frontend\controllers\RegistrationController',
                'security' => 'frontend\controllers\SecurityController',
                'settings' => 'frontend\controllers\SettingsController',
            ],
            //'enableRegistration' => false,
            //'enableConfirmation' => false,
            //'enablePasswordRecovery' => false,
            'enableUnconfirmedLogin' => true,
            'admins' => ['admin'],
            'modelMap' => [
                'RegistrationForm' => [
                    'class' => 'frontend\models\RegistrationForm',
                ],
                'Profile' => [
                    'class' => 'frontend\models\Profile',
                ],
                'User' => [
                    'class' => 'frontend\models\User',
                ],
            ],
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'messageManager'=>[
            'class'=>'frontend\models\MessageManager',
            // userInformation 是一个用户表的activeRecord,主要作用当你发送消息的时候，将用户表里面的消息总数＋１，当你阅读完消息的时候，将用户表里面的消息数－１，
            // 通过实现UserInformationInterface,里面的两个方法
            'userInformation'=>[
                'class'=>'dektrium\user\Module',
            ]
        ]

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'site/login',
            'site/error',
            'admin/*',
            'user/*',
            'tracks/get-track-url',
            'playlist/getuserplaylist'
            //'gii/*',
            //'some-controller/some-action',
            //此处的action列表，允许任何人（包括游客）访问
            //所以如果是正式环境（线上环境），不应该在这里配置任何东西，为空即可
            //但是为了在开发环境更简单的使用，可以在此处配置你所需要的任何权限
            //在开发完成之后，需要清空这里的配置，转而在系统里面通过RBAC配置权限
        ]
    ],
];
