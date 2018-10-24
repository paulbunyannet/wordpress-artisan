<?php

namespace Pbc\WordpressArtisan\Commands\Wordpress\Cache;

use Corcel\Model\Option;
use Illuminate\Console\Command;
use Pbc\WordpressArtisan\Helpers;

/**
 * Class CallRoute
 * @package App\Console\Commands
 */
class ClearTransientCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:clear-transient-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Wordpress transient cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clear = $this->clearTransients();
        if($clear !== 0) {
            $this->error(Helpers::getLang(get_class($this), 'error', ['count' => $clear]));
            return;
        }
        $this->info(Helpers::getLang(get_class($this), 'success', []));
        return;
    }

    /**
     * Clear the transients and check that they are all gone
     * @return integer
     */
    protected function clearTransients()
    {
        // https://coderwall.com/p/yrqrkw/delete-all-existing-wordpress-transients-in-mysql-database
        // DELETE FROM `wp_options` WHERE `option_name` LIKE ('_transient_%');
        // DELETE FROM `wp_options` WHERE `option_name` LIKE ('_site_transient_%');
        Option::where('option_name', 'like', '_transient_%')->delete();
        Option::where('option_name', 'like', '_site_transient_%')->delete();
        return Option::where('option_name', 'like', '%_transient_%')->count();
    }
}
