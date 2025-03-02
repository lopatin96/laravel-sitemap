# Install
### Publish config
```php
php artisan vendor:publish --tag="laravel-sitemap-config"
```
and specify your sitemap settings in `config/sitemap.php`


### Link to sitemap
Your sitemap.xml file is under http:://127.0.0.1/sitemap.xml`

# Publishing
### Config
```php
php artisan vendor:publish --tag="laravel-sitemap-config"
```

# Custom pages
Set custom_pages to true in config/sitemap.php and add a class to your project:

```php
namespace App\Services\SitemapCustomPages;

use App\Models\Item;

class SitemapCustomPages extends \Atin\LaravelSitemap\Services\SitemapCustomPages
{
    public function addPages(): void
    {
        Item::get()->each(function ($item) {
            $this->pages->push([
                'url' => url("/offers/$item->slug"),
                'last_modified' => $item->updated_at,
            ]);
        });
    }
}
```