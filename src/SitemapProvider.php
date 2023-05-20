<?php

namespace Atin\LaravelSitemap;

use Illuminate\Support\ServiceProvider;

class SitemapProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-sitemap.php')
        ], 'laravel-sitemap-config');
    }
}