# Wordpress Artisan commands

[![Build Status](https://travis-ci.org/paulbunyannet/wordpress-artisan.svg?branch=master)](https://travis-ci.org/paulbunyannet/wordpress-artisan)

    wp
        wp:down                   Put Wordpress in maintenance mode
        wp:keys                   Generate Wordpress Authentication keys
        wp:up                     Bring Wordpress back out of maintenance mode
        wp:clear-transient-cache  Clear all the transient caches from the database

## Config

Run `php artisan vendor:publish --provider="Pbc\WordpressArtisan\WordpressArtisanServiceProvider" --tag="config" --tag="lang"` to get the configuration and language files and then update as needed.

## Commands

### Wordpress Maintenance

Put Wordpress in maintenance mode.

#### Usage

`php artisan wp:down` to put WP in maintenance mode

`php artisan wp:up` to bring WP back out of maintenance mode

### Wordpress Secret Keys

Builds Wordpress authentication keys and applies them to the .env file, similar to the keys generated at https://api.wordpress.org/secret-key/1.1/salt/

#### Usage

`php artisan wp:keys` to generate new keys

### Wordpress Clear Transient Cache

Clear all the transient caches from the database. Requires https://github.com/corcel/corcel to be installed and configured.

#### Usage

`php artisan wp:clear-transient-cache` to clear the transient caches from the database

## Roadmap

Add other useful artisan commands to interact with wordpress. If you have an idea send in a PR.

## License

The wordpress-artisan package is open-sourced software licensed under the MIT license

## laravel compatibility by tag

| laravel v | wordpress-artisan v |
|-----------|---------------------|
| 5.1 - 5.2 | 1.*                 |
| 5.3       | >1.03 - 1.05        |
| 5.4       | 1.1                 |
| 5.5       | 1.2                 |
| 5.6       | 1.3                 |
| 5.7       | 1.4                 |
| 5.8       | 1.5                 |
