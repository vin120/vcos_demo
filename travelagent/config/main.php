<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-travelagent',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'travelagent\controllers',
    'components' => [
    		/*'assetManager' => [
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
    				],*/
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
            'identityClass' => 'travelagent\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__agent_identity','httpOnly' => true],
            'idParam' => 'agent',
            'loginUrl' => ['site/login'],
        ],
        'session' => [
            'name'=>'agent',
        ],
    		/* -------------------------------- */
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
