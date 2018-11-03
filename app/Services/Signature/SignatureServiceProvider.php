<?php

namespace App\Services\Signature;

use Illuminate\Support\ServiceProvider;

/**
 * Class SignatureServiceProvider.
 */
class SignatureServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Services\Signature\SignatureService', function($app) {
            return new SignatureService(config('signature'));
        });
    }

    public function provides()
    {
        return array('App\Services\Signature\SignatureService');
    }
}
