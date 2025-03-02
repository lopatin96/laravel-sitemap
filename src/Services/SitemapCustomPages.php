<?php

namespace Atin\LaravelSitemap\Services;

use Illuminate\Support\Collection;

abstract class SitemapCustomPages
{
    public Collection $pages;

    public function __construct()
    {
        $this->pages = collect();

        $this->addPages();
    }

    public function getPages(): Collection
    {
        return $this->pages;
    }

    abstract public function addPages(): void;
}