<?php
namespace Pbc\WordpressArtisan\Commands\Wordpress\Maintenance;

use Illuminate\Console\Command;
use Pbc\WordpressArtisan\Manager;


/**
 * Class WpDown
 *
 * Put wordpress in a maintenance mode
 * Maintenance mode is handled by Wordpress theme with a
 * int hook to check for the maintenance file
 * @package App\Console\Commands
 */
class Down extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:down {--dir=default} {--file=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put Wordpress in maintenance mode';
    /**
     * @var Generate
     */
    protected $generator;
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Create a new command instance.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        parent::__construct();

        $this->manager = $manager;

        $this->generator = new Generate($this);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getFilePath()
    {
        return $this->getPath() . $this->getFileName();
    }

    /**
     *
     */
    public function handle()
    {
        $filePath = $this->getFilePath();
        $eol = PHP_EOL;

        $this->generator->makeGitIgnore();
        if (file_exists($this->getFilePath())) {
            $this->error(PHP_EOL . 'Wordpress is already down.' . PHP_EOL);
        } else {
            $this->generator->makeMaintenanceFile();
            $this->info("{$eol}Wordpress set to maintenance mode. Either run \"artisan wp:up\" to {$eol} bring the site back up or manually delete {$eol} {$filePath}.");
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getPath()
    {
        $storage = $this->manager->getConfig('public_path');
        $dir = $this->getDir();

        if ($dir) {
            return $storage . '/' . $dir . '/';
        }
        return $storage . '/';
    }

    /**
     * @return array|bool|mixed|string|null
     * @throws \Exception
     */
    public function getFileName()
    {
        if (!$this->option('file') || $this->option('file') === 'default') {
            return $this->manager->getConfig('wp-maintenance-file');
        }

        return $this->option('file');
    }

    /**
     * @return array|bool|mixed
     */
    protected function getDir()
    {
        if (!$this->option('dir') || $this->option('dir') === 'default') {
            return false;
        }
        return $this->option('dir');

    }
}
