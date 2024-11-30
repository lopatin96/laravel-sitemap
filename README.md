# Install
### Publish config
```php
php artisan vendor:publish --tag="laravel-sitemap-config"
```
and specify your sitemap settings in `config/sitemap.php`

### Console
Add `GenerateSitemap` to `app/Console/Kernel.php`
```php
use Atin\LaravelSitemap\Console\GenerateSitemap;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(new GenerateSitemap)->daily();
```

### Custom links
You can provide your list of links to the constructor of `GenerateSitemap`. These links also will be added to te `sitemap.xml`

Example of links:
```php
[
    [
        'url' => '/custom-link-1',
        'last_modified' => '2024-11-30',
    ],
    [
        'url' => '/custom-link-2',
        'last_modified' => '2024-11-30',
    ],
    …
]
```


### Link to sitemap
Your sitemap.xml file is under http:://127.0.0.1/sitemap`

# Publishing
### Config
```php
php artisan vendor:publish --tag="laravel-sitemap-config"
```