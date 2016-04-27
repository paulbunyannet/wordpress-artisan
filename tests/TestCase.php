<?php

use Faker\Factory;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    /** @var \Faker\Factory */
    protected $faker;
    protected $consoleOutput;

    protected function getPackageProviders($app)
    {
        return [\Pbc\WordpressArtisan\WordpressArtisanServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wordpress-artisan.path', $this->getPath());
    }

    protected function getPath()
    {
        return __DIR__ . '/temp';
    }

    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
        exec('if [ ! -d "'. $this->getPath() .'" ]; then mkdir '. $this->getPath() .'; fi;');
    }

    public function tearDown()
    {
        parent::tearDown();

        exec('rm -rf '.$this->getPath());

        $this->consoleOutput = '';
    }

    public function resolveApplicationConsoleKernel($app)
    {
        $app->singleton('artisan', function ($app) {
            return new \Illuminate\Console\Application($app, $app['events'], $app->version());
        });

        $app->singleton('Illuminate\Contracts\Console\Kernel', Kernel::class);
    }

    public function artisan($command, $parameters = [])
    {
        parent::artisan($command, array_merge($parameters, ['--no-interaction' => true]));
    }

    public function consoleOutput()
    {
        return $this->consoleOutput ?: $this->consoleOutput = $this->app[Kernel::class]->output();
    }
}
