<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/sitemap', static function () {
    $content = Storage::disk('s3')->get('sitemaps/sitemap.xml');

    // Возврат файла с корректными заголовками
    return response($content, 200, [
        'Content-Type' => 'application/xml',
        'Content-Disposition' => 'attachment; filename="sitemap.xml"',
    ]);
});