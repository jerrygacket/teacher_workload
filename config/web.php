<?php

use app\components\AuthComponent;
use app\components\CatalogComponent;
use app\components\DepartmentsComponent;
use app\components\InstitutesComponent;
use app\components\RbacComponent;
use app\components\UsersComponent;

$params = require __DIR__ . '/params.php';
$db = file_exists(__DIR__ . '/db_local.php')
    ? (require __DIR__ . '/db_local.php')
    : (require __DIR__ . '/db.php');
$fbDb = file_exists(__DIR__ . '/fb_connect_local.php')
    ? (require __DIR__ . '/fb_connect_local.php')
    : (require __DIR__ . '/fb_connect.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'name' => 'Индивидуальная нагрузка',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'ru-RU',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'catalog' => ['class'=> CatalogComponent::class,'nameClass'=>'\app\models\Catalog'],
        'departments' => ['class'=> DepartmentsComponent::class,'nameClass'=>'\app\models\Departments'],
        'institutes' => ['class'=> InstitutesComponent::class,'nameClass'=>'\app\models\Institutes'],
        'users' => ['class'=> UsersComponent::class,'nameClass'=>'\app\models\Users'],
        'auth' => ['class'=> AuthComponent::class,'nameClass'=>'\app\models\Users'],
        'authManager' => ['class'=>'\yii\rbac\DbManager'],
        'rbac'=>['class'=> RbacComponent::class],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WohviMuakiezeig4ahthoofea9lae4OhXee9aeng',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => '\app\models\Users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'fbDb' => $fbDb,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'allowedIPs' => ['*'],
    ];
}

return $config;
