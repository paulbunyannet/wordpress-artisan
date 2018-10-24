<?php
namespace Pbc\WordpressArtisan;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Pbc\WordpressArtisan\Commands\Wordpress\Cache\ClearTransientCache;
use Pbc\WordpressArtisan\Commands\Wordpress\Maintenance\Down;
use Pbc\WordpressArtisan\Commands\Wordpress\Maintenance\Up;
use Pbc\WordpressArtisan\Commands\Wordpress\SecretKey\Create;

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
            __DIR__ . '/../resources/lang/en/pbc/wordpressartisan/commands/wordpress/cleartransientcache.php' => resource_path('lang/pbc/wordpressartisan/commands/wordpress/cache/cleartransientcache'),
        ]);
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
            Up::class,
            Down::class,
            Create::class,
            ClearTransientCache::class,
        ]);
    }
}