# Wordpress Artisan commands

[![Build Status](https://travis-ci.org/paulbunyannet/wordpress-artisan.svg?branch=master)](https://travis-ci.org/paulbunyannet/wordpress-artisan)

    wp
        wp:down              Put Wordpress in maintenance mode
        wp:keys              Generate Wordpress Authentication keys
        wp:up                Bring Wordpress back out of maintenance mode 

## Config

Run `php artisan vendor:publish --provider="Pbc\WordpressArtisan\WordpressArtisanServiceProvider" --tag="config"` to get the configuration file and then update as needed.

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

## Roadmap

Add other useful artisan commands to interact with wordpress. If you have an idea send in a PR.

## License

The wordpress-artisan package is open-sourced software licensed under the MIT license
