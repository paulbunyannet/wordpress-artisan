<?php 
namespace Pbc\WordpressArtisan\Commands\Wordpress\Maintenance;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Pbc\WordpressArtisan\Manager;

/**
 * Class WpUp
 *
 * Pull Wordpress out of maintenance mode
 * Maintenance mode is handled by Wordpress theme with a
 * int hook to check for the maintenance file
 * @package App\Console\Commands
 */
class Up extends Down
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:up {--dir=default} {--file=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bring Wordpress back out of maintenance mode';
    protected $destroyer;

    /**
     * Create a new command instance.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        parent::__construct($manager);
        $this->destroyer = new Destroy($this);
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        if(file_exists($this->getFilePath())) {
            $this->destroyer->removeMaintenanceFile();
            $this->info(PHP_EOL.'Wordpress is back up.'.PHP_EOL);
        } else {
            $this->error(PHP_EOL.'Wordpress is already up.'.PHP_EOL);
        }
    }
}
