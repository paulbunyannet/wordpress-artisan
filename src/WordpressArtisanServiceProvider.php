<?php
namespace Pbc\WordpressArtisan;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ArtisanWordpressServiceProvider
 * @package Pbc\ArtisanWordpress
 */
class WordpressArtisanServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/wordpress-artisan.php' => config_path('wordpress-artisan.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang/en/pbc/wordpressartisan/commands/wordpress/cleartransientcache.php' => resource_path('lang/en/pbc/wordpressartisan/commands/wordpress/cache/cleartransientcache.php'),
        ], 'lang');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wordpress-artisan.php', 'wordpress-artisan');

        $this->app->bind(Manager::class, function () {
            return new Manager(
                new Filesystem,
                $this->app['config']['wordpress-artisan']
            );
        });
        
        $this->commands([
            \Pbc\WordpressArtisan\Commands\Wordpress\Maintenance\Up::class,
            \Pbc\WordpressArtisan\Commands\Wordpress\Maintenance\Down::class,
            \Pbc\WordpressArtisan\Commands\Wordpress\SecretKey\Create::class,
            \Pbc\WordpressArtisan\Commands\Wordpress\Cache\ClearTransientCache::class,
        ]);
    }
}