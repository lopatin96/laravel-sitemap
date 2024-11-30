<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/sitemap', static function () {
    $content = Storage::disk('s3')->get(config('laravel-sitemap.path'));

    return response($content, 200, [
        'Content-Type' => 'application/xml',
        'Content-Disposition' => 'attachment; filename="sitemap.xml"',
    ]);
});