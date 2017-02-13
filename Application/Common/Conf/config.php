<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_FILE_DEPR'=>'_',
	'DB_USER' => 'root',
	'DB_HOST' => '182.254.221.218',
	'DB_TYPE' => 'mysql',
	'DB_PWD' => 'shiyiroot..',
	'DB_PREFIX' => 'xd_',
	'DB_NAME' => 'xiadan',
	'URL_MODEL'          => '2', //URL模式
	'MODULE_ALLOW_LIST'    =>    array('Home','Admin'),
	'DEFAULT_MODULE' => 'Home', //默认模块
	'URL_CASE_INSENSITIVE'  =>  true,

    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

    "TEE_PAY" => array(
        'TEE_SITE_URL' => "https://teegon.com/",
        'TEE_API_URL' => 'https://api.teegon.com/',
        'TEE_CLIENT_ID' => 'xun2glglx4hzaplrtufenedl',
        'TEE_CLIENT_SECRET' => 'ezgyqehdmybicbtljp2pzdrbie24l7lu',
    ),
);