<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    // 设置目标语言为中文
    'language' => 'zh-CN',
    // 设置源语言为英语
    'sourceLanguage' => 'en-US',
    'timeZone'=>'Asia/Chongqing',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'controlcenter' => [
            'class' => 'app\modules\controlcenter\Module',
        ],
        'membership' => [
            'class' => 'app\modules\membermanagement\Member',
        ],
        'voyage' => [
            'class' => 'app\modules\voyagemanagement\Voyage',
        ],
        'travelagent' => [
            'class' => 'app\modules\travelagentmanagement\Travelagent',
        ],
        'order' => [
            'class' => 'app\modules\ordermanagement\Order',
        ],
        'org' => [
            'class' => 'app\modules\orgmanagement\Org',
        ],
        'wifibilling' => [
            'class' => 'app\modules\wifibillingmanagement\Wifibilling',
        ],
        'boardingapi' => [
            'class' => 'app\modules\boardingsystem\Boarding',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//yii2-admin的导航菜单
        ],
        'wifiservice' => [
            'class' => 'app\modules\wifiservice\Wifiservice',
        ],
    ],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__admin_identity', 'path' => '/','httpOnly' => true],
            'idParam' => 'admin',
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            'name'=>'admin',
            'cookieParams' => [
                'path' => '/',
                'httpOnly' => true,
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => 'app\messages',  //php文件保存位置
                    'fileMap' => [
                        'app' => 'app.php',
//                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
            'ruleTable' => 'auth_rule'
        ],
    /*
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,//
            'showScriptName' => true,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'admin'],
            ],
        ],
        */

    ],

//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',//允许访问的节点，可自行添加
//            'admin/*',//允许所有人访问admin节点及其子节点
//            'debug/*',//允许所有人访问debug节点及其子节点
//        ]
//    ],

    'params' => $params,
];
