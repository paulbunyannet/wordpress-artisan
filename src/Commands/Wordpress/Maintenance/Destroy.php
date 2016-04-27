<?php
namespace Pbc\WordpressArtisan\Commands\Wordpress\Maintenance;

/**
 * Class WpDestroy
 * @package App\Console\Commands\Wordpress
 */
class Destroy
{
    protected $upClass;

    public function __construct(Up $upClass)
    {
        $this->upClass = $upClass;
    }

    /**
     * Remove the maintenance file
     * @return mixed
     */
    public function removeMaintenanceFile()
    {
        $path = $this->upClass->getFilePath();
        return exec("rm -f {$path}");
    }
    
}