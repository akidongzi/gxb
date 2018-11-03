<?php
// Oss 配置

return [
	'bucket' => env('ALIYUN_OSS_BUCKET','cici-images'),
	'accessKeyId' => env('ALIYUN_OSS_ACCESS_KEY', 'LTAIVYIeUAm3S9K0'),
	'accessKeySecret' => env('ALIYUN_OSS_BUCKET_SECRET', 'YTq5auADeXgldt3QXBwzIYUq38TSW7'),
	'endpoint' => env('ALIYUN_OSS_BUCKET_ENDPOINT', 'http://oss-cn-beijing.aliyuncs.com'),
	'domain' => env('ALIYUN_OSS_BUCKET_DOMAIN', 'https://cici-images.oss-cn-beijing.aliyuncs.com'),
];