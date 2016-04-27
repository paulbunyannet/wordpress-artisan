<?php
namespace Pbc\WordpressArtisan;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;


/**
 * Class Manager
 * @package Pbc\WordpressArtisan
 */
class Manager
{

    /**
     * @var Filesystem
     */
    protected $disk;
    /**
     * @var array
     */
    protected $config;

    /**
     * Manager constructor.
     * @param Filesystem $disk
     * @param array $config
     */
    public function __construct(Filesystem $disk, array $config)
    {
        $this->disk = $disk;
        $this->config = $config;
    }

    /**
     * Get config
     *
     * @param null $key
     * @return array|mixed
     * @throws \Exception
     */
    public function getConfig($key=null) {
        if($key && array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        if($key && !array_key_exists($key, $this->config)) {
            throw new \Exception('Config item "'. $key .'" was not found');
        }

        return $this->config;
    }

}