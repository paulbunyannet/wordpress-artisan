<?php

namespace Pbc\WordpressArtisan\Commands\Wordpress\SecretKey;

use Illuminate\Console\Command;
use Pbc\WordpressArtisan\Manager;
use Illuminate\Support\Str;

/**
 * Class Create
 *
 * Create wordpress app security keys
 * @package App\Console\Commands
 */
class Create extends Command
{
    /**
     * @var string
     */
    protected $signature = 'wp:keys {--file=default}  {--AUTH_KEY=generate} {--SECURE_AUTH_KEY=generate} {--LOGGED_IN_KEY=generate} {--NONCE_KEY=generate} {--AUTH_SALT=generate} {--SECURE_AUTH_SALT=generate} {--LOGGED_IN_SALT=generate} {--NONCE_SALT=generate}';
    /**
     * @var string
     */
    protected $description = 'Generate Wordpress Authentication keys';
    /**
     * @var string
     */
    protected $findRegEx = '/(#KEY#)(=)(").*?(")/is';
    /**
     * @var string
     */
    protected $findRegExPlaceholder = '#KEY#';

    /**
     * @var array
     */
    protected $keys = [
        'AUTH_KEY',
        'SECURE_AUTH_KEY',
        'LOGGED_IN_KEY',
        'NONCE_KEY',
        'AUTH_SALT',
        'SECURE_AUTH_SALT',
        'LOGGED_IN_SALT',
        'NONCE_SALT'
    ];
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Create a new command instance.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }


    /**
     * Handle generating the Wordpress auth keys
     */
    public function handle()
    {
        /** @var string $path path to the env file */
        $path = $this->getFilePath();
        if (!file_exists($path)) {
            file_put_contents($path, "");
        }

        /** @var string $content current content in the env file */
        $content = file_get_contents($path);

        foreach ($this->generateKeys() as $key) {
            /** try and match the value in the env file by regex, if not
             * found then append the key to the bottom of the
             * file
             */
            preg_match($key['regex'], $content, $matches);
            if ($matches) {
                $content = preg_replace($key['regex'], $key['value'], $content);
            } else {
                $content .= $key['value'] . PHP_EOL;
            }
        }
        /** apply changes */
        file_put_contents($path, $content);
        $this->info('Wordpress keys regenerated');
    }

    /**
     * build file path to env file
     *
     * @return string
     * @throws \Exception
     */
    private function getFilePath()
    {
        return $this->manager->getConfig('path') . '/' . $this->getFileName();
    }

    /**
     * Generate regex used for replacing the key value in the env file and
     * the value that should be used in place
     * @return array
     */
    private function generateKeys()
    {
        $content = [];
        for ($i = 0; $i < count($this->keys); $i++) {
            $holder = [];
            $value = !$this->option($this->keys[$i]) || $this->option($this->keys[$i]) === 'generate' ? Str::random(64) : $this->option($this->keys[$i]);
            $holder['regex'] = Str::replaceFirst($this->findRegExPlaceholder, $this->keys[$i], $this->findRegEx);
            $holder['value'] = $this->keys[$i] . '="' . $value . '"';
            array_push($content, $holder);
        }

        return $content;
    }

    public function getFileName()
    {

        if (!$this->option('file') || $this->option('file') === 'default') {
            return $this->manager->getConfig('env-file');
        }

        return $this->option('file');

    }
}