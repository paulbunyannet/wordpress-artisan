<?php

class Kernel extends \Illuminate\Foundation\Console\Kernel
{
    /**
     * The bootstrap classes for the application.
     *
     * @return void
     */
    protected $bootstrappers = [];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * @param Throwable $e
     * @throws Throwable
     */
    protected function reportException(Throwable $e)
    {
        throw $e;
    }

    public function getArtisan()
    {
        return $this->app['artisan'];
    }
}
