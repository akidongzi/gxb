<?php

/** 
 * 签名配置
 */
return [
	'secret'  => env('ACCESS_SECRET', 'test'), // 密钥正式环境可设置复杂一些的字串
	'timeout' => env('ACCESS_TIMEOUT', 60), // 过期时间(单位秒)
];