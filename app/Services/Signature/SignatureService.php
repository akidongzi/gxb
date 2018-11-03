<?php

namespace App\Services\Signature;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Log;

/**
 * 接口签名校验类
 */
class SignatureService
{
	/*
	 * 初始化配置
	 *
	 * @param  array $config
	 * @return string
	 */
	public function __construct($config)
	{
		$this->secret  = $config['secret'];
		$this->timeout = $config['timeout'];
	}

	/*
	 * 签名校验
	 *
	 * @param  Illuminate\Http\Request $request
	 * @return bool
	 */
	public function check(Request $request)
	{
		$signature = $request->get('sign');
		$ts = intval($request->get('ts'));

		// 过期判断
		$now = time();
		if (($now - $ts) > $this->timeout) {
			return false;
		}

		$sign = $this->sign($request);

		return $sign == $signature;
	}

	/**
	 * 生产签名
	 *
	 * @param  Illuminate\Http\Request $request
	 * @return string
	 */
	public function sign(Request $request)
	{
		// 1. 去除参数中的空值
		$params = array_filter($request->json()->all());

		// 2. 将所有请求参数按字母先后顺序排序
		ksort($params);
		// 3. 拼接字符串 格式: a=xx&b=xx&c=xx
		$string = urldecode(http_build_query($params));

		// 4. md5 加密
		$sign = md5($string.md5($this->secret));

		Log::debug('api.article.sign', ['params'=> $params, 'string' => $string.md5($this->secret), 'sign' => $sign]);
		return $sign; 
	}
}