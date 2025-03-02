<?php

use Atin\LaravelSitemap\Services\SitemapGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', static function () {
    $customPages = config('laravel-sitemap.custom_pages', false)
        ? (new App\Services\SitemapCustomPages\SitemapCustomPages())->getPages()
        : collect();

    return response((new SitemapGenerator($customPages))->render(), 200, [
        'Content-Type' => 'application/xml',
        'Content-Disposition' => 'attachment; filename="sitemap.xml"',
    ]);
});