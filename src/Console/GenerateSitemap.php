<?php

namespace Atin\LaravelSitemap\Console;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Atin\LaravelBlog\Models\Post;

class GenerateSitemap
{
    private Sitemap $sitemap;
    
    private array $customUrls;

    public function __construct(array $customUrls = [])
    {
        $this->sitemap = Sitemap::create();
        $this->customUrls = $customUrls;
    }

    public function __invoke(): void
    {
        $this->addDefaultUrls();

        $this->addLocales();

        $this->addBlogPosts();

        $this->addCustomUrls();

        $this->save();
    }

    private function addDefaultUrls(): void
    {
        foreach (config('laravel-sitemap.default_urls') as $item) {
            if (is_array($item) && isset($item['url'], $item['last_modified'])) {
                $this->sitemap->add(
                    Url::create(url($item['url']))
                        ->setLastModificationDate(Carbon::parse($item['last_modified']))
                );
            }
        }
    }

    private function addLocales(): void
    {
        if (config()->has('laravel-lang-switcher')) {
            foreach (array_keys(config('laravel-lang-switcher.languages')) as $locale) {
                $this->sitemap->add(
                    Url::create(url("/$locale"))
                        ->setLastModificationDate(now())
                );
            }
        }
    }

    private function addBlogPosts(): void
    {
        if (config()->has('laravel-blog')) {
            Post::where('published', true)->get()->each(function (Post $post) {
                $this->sitemap->add(
                    Url::create(url("/blog/$post->slug"))
                        ->setLastModificationDate($post->updated_at)
                );
            });
        }
    }
    
    private function addCustomUrls(): void
    {
        foreach ($this->customUrls as $item) {
            if (is_array($item) && isset($item['url'], $item['last_modified'])) {
                $this->sitemap->add(
                    Url::create(url($item['url']))
                        ->setLastModificationDate(Carbon::parse($item['last_modified']))
                );
            }
        }
    }

    private function save(): void
    {
        Storage::disk('s3')->put(config('laravel-sitemap.path'), $this->sitemap->render(), 'public');
    }
}
