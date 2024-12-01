<?php

use Atin\LaravelSitemap\Services\SitemapGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', static function () {
    return response(( new SitemapGenerator())->render(), 200, [
        'Content-Type' => 'application/xml',
        'Content-Disposition' => 'attachment; filename="sitemap.xml"',
    ]);
});