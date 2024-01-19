<?php

namespace Zapply\Laravel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Zapply\Zapply;

class ZapplyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Zapply::class, function ($app) {
            return new Zapply([
                'base_uri' => config('zapply.base_uri'),
                'api_key' => config('zapply.api_key'),
                'channel_id' => config('zapply.channel_id'),
            ]);
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/zapply.php',
            'zapply'
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/zapply.php' => $this->app->configPath('zapply.php'),
            ], 'zapply-config');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Route::group([
            'prefix' => 'zapply',
            'namespace' => 'Zapply\Laravel\Http\Controllers',
            'as' => 'zapply.',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}