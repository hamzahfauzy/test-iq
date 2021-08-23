<?php

$params = require __DIR__ . '/params.php';
$jurusan = require __DIR__ . '/jurusan.php';

$params = array_merge($params, $jurusan);
$params['instrumen_jurusan'] = [
    'TO'=>'R',
    'TK'=>'R',
    'AK'=>'C',
    'AP'=>'I',
    'TKim'=>'I',
    'TM'=>'R',
    'ADK' => 'C',
    'DISKOMVIS' => 'A',
    'TLAS' => 'R',
    'TELEK' => 'R',
    'BUS' => 'A',
    'TSIP' => 'R'
];
$db = require __DIR__ . '/db.php';

$config = [
    'timeZone'=>'Asia/Jakarta',
    'name' => 'TMC IQ TEST',
    'id' => 'minatbakatapp',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'id'
                ]
            ],
        ]
    ],
    'components' => [
        'view' => [
            'class' => 'app\components\CustomView'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'minatbakatapp',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
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
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['as access'] =  [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            // '*',
            'api/*',
            'rest/*',
            'site/laporan'
            // 'admin/*',
            // 'gii/*',
            // 'debug/*',
            // 'ajax/*'
        ]
    ];
}

return $config;
