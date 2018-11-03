<?php

namespace App\Services\Aliyun;

use Illuminate\Support\ServiceProvider;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 * 图片上传
 * 
 * Example
 * $file = '/Users/zhaoyongbin/Tmp/zhwhzcq/storage/banner.jpg';
 * $object = $ossClientService->uploadFile($file);
 * $url    = $ossClientService->getPicUrl($object, 200, 200);
 */
class OssClientService
{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $endpoint;
    protected $bucket;
    protected $domain;

    public function __construct($config)
    {
        $this->accessKeyId = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->endpoint = $config['endpoint'];
        $this->bucket = $config['bucket'];
        $this->domain = $config['domain'];
    }

    public function getOssClient()
    {
        try {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint, false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    public function getBucketName()
    {
        return $this->bucket;
    }

    public function uploadFile($filePath)
    {
        $ossClient = $this->getOssClient();
        $info   = pathinfo($filePath);
        if (!isset($info['extension'])) {
            $info['extension'] = 'jpg';
        }
        $object = sprintf("%s/%s/%s.%s", date('Ym'), date('d'), 
            str_replace('=', '', base64_encode($filePath)), $info['extension']);

        $result = $ossClient->uploadFile($this->bucket, $object, $filePath);
        return $object;
    }

    public function getFullPicUrl($object)
    {
        if (strpos($object, 'https://') !== false || strpos($object, 'http://') !== false) {
            return $object;
        } else {
            return sprintf("%s/%s", $this->domain, $object);
        }
    }

    public function getResizePicUrl($url, $widht = 0, $height = 0, $m = 'fill')
    {
        if ($widht) {
            $url = sprintf("%s?x-oss-process=%s,m_%s,w_%s,h_%s", $url, 'image/resize', 'fill', $widht, $height);
        }
        return $url;
    }
}
