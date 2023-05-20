<?php

use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', static function () {
    return response()->redirectTo(config('app.asset_url').'/sitemap.xml', 302, [
        'Content-Type' => 'text/plain',
        'Cache-Control' => 'public, max-age=3600',
    ]);
});

if (App::environment() !== 'production') {
    Route::get('/sitemap', static function () {
        SitemapGenerator::create('https://antiplagiarism.online')
            ->writeToFile('sitemap.xml');
    });
}