<?php

namespace Atin\LaravelSitemap\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use Atin\LaravelBlog\Models\Post;
use Illuminate\Support\Collection;

class SitemapGenerator
{
    private Sitemap $sitemap;

    private Collection $customPages;

    public function __construct(Collection $customPages)
    {
        $this->sitemap = Sitemap::create();

        $this->customPages = $customPages;

        $this->addUrlsToSitemap();
    }

    public function addUrlsToSitemap(): void
    {
        $this->addDefaultUrls();

        $this->addLocales();

        $this->addBlogPosts();

        $this->addCustomPages();
    }

    private function addDefaultUrls(): void
    {
        foreach (config('laravel-sitemap.default_urls') as $item) {
            if (is_array($item) && isset($item['url'], $item['last_modified'])) {
                $this->sitemap->add(
                    Url::create(url($item['url']))->setLastModificationDate(Carbon::parse($item['last_modified']))
                );
            }
        }
    }

    private function addLocales(): void
    {
        if (config()->has('laravel-lang-switcher')) {
            foreach (array_keys(config('laravel-lang-switcher.languages')) as $locale) {
                $this->sitemap->add(
                    Url::create(url("/$locale"))->setLastModificationDate(now())
                );
            }
        }
    }

    private function addBlogPosts(): void
    {
        if (config()->has('laravel-blog')) {
            Post::where('published', true)->get()->each(function (Post $post) {
                $this->sitemap->add(
                    Url::create(url("/blog/$post->slug"))->setLastModificationDate($post->updated_at)
                );
            });
        }
    }

    private function addCustomPages(): void
    {
        foreach ($this->customPages as $page) {
            $this->sitemap->add(
                Url::create($page['url'])->setLastModificationDate($page['last_modified'] ?? now())
            );
        }
    }

    public function render(): string
    {
        return $this->sitemap->render();
    }
}