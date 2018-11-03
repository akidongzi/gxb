<?php
/**
 * Created by PhpStorm.
 * User: lindowx
 * Date: 2018/10/16
 * Time: 11:56
 */

namespace App\Exceptions;

use Throwable;

class ApiException extends \Exception
{
    public const ERR_SERVER_ERROR       = 500;
    public const ERR_SIGNATURE_MISMATCH = 403;
    public const ERR_BAD_REQUEST        = 400;

    public static $errorMap = [
        self::ERR_SERVER_ERROR          => '接口服务器错误',
        self::ERR_SIGNATURE_MISMATCH    => '接口签名错误',
        self::ERR_BAD_REQUEST           => '错误的请求',
    ];

    /**
     * 取得错误码对应的错误信息
     *
     * @param int $code
     * @return string
     */
    public static function m($code)
    {
        return static::$errorMap[$code];
    }

    /**
     * 获取Exception实例
     *
     * @param int $code
     * @param string $debugMessage
     * @return static
     */
    public static function e($code = 0, $debugMessage = '')
    {
        if (! env('API_DEBUG')) {
            $debugMessage = null;
        }

        if (is_int($code) && isset(static::$errorMap[$code])) {
            if (! empty($debugMessage)) {
                $errorMessage = sprintf('%s: %s', static::$errorMap[$code], $debugMessage);
            } else {
                $errorMessage = sprintf('%s', static::$errorMap[$code]);
            }

            return new static($errorMessage, $code);
        }

        if (! empty($debugMessage)) {
            $errorMessage = sprintf('接口错误(%d): %s', $code, $debugMessage);
        } else {
            $errorMessage = sprintf('接口错误(%d)', $code);
        }

        return new static($errorMessage);
    }

}