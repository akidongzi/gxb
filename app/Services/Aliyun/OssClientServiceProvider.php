<?php

namespace App\Services\Aliyun;

use Illuminate\Support\ServiceProvider;

/**
 * Class OssClientServiceProvider.
 */
class OssClientServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register any misc. blade extensions.
     */
    public function register()
    {
        $this->app->singleton('App\Services\Aliyun\OssClientService', function($app) {
            return new OssClientService(config('oss'));
        });
    }

    public function provides()
    {
        return array('App\Services\Aliyun\OssClientService');
    }
}
