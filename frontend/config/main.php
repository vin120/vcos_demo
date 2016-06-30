<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
	'defaultRoute' => 'route',
    'components' => [
    		
    		'assetManager' => [
    				'hashCallback' => function ($path) {
    				if (!function_exists('_myhash_')) {
    					function _myhash_($path) {
    						if (is_dir($path)) {
    							$handle = opendir($path);
    							$hash = '';
    							while (false !== ($entry = readdir($handle))) {
    								if ($entry === '.' || $entry === '..') {
    									continue;
    								}
    								$entry = $path . '/' . $entry;
    								$hash .= _myhash_($entry);
    							}
    							$result = sprintf('%x', crc32($hash . Yii::getVersion()));
    						} else {
    							$result = sprintf('%x', crc32(filemtime($path) . Yii::getVersion()));
    						}
    						return $result;
    					}
    				}
    				return _myhash_($path);
    				}
    				],
    				
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
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
    		
    	'view' => [
    		'theme' => [
    			'pathMap' => ['@frontend/views' => '@frontend/views/themes/basic'],
    			'baseUrl' => '@frontend/views/themes/basic',
    		],
    	],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
            'ruleTable' => 'auth_rule',
        ],

    ],
    'params' => $params,
];
