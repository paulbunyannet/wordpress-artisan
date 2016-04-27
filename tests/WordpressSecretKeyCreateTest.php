<?php

class WordpressSecretKeyCreateTest extends TestCase
{
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
     * @test
     */
    public function it_has_correct_keys_set_to_env_file()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:keys', ['--file' => $filename]);
        $this->assertFileExists($this->getPath() . '/'. $filename);
        $content = file_get_contents($this->getPath() . '/'. $filename);

        for($i=0; $i < count($this->keys); $i++) {
            $this->assertContains($this->keys[$i].'="', $content);
        }
    }
    /**
     * @test
     */
    public function it_has_correct_keys_set_to_default_file()
    {
        $filename = '.env';
        $this->artisan('wp:keys', []);
        $this->assertFileExists($this->getPath() . '/'. $filename);
        $content = file_get_contents($this->getPath() . '/'. $filename);

        for($i=0; $i < count($this->keys); $i++) {
            $this->assertContains($this->keys[$i].'="', $content);
        }
    }

    /**
     * @test
     */
    public function it_has_correct_keys_updated_to_env_file()
    {
        /**
         * Setup the config the first time and then update the values
         */
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:keys', ['--file' => $filename]);
        $this->assertFileExists($this->getPath() . '/'. $filename);
        $secondConfig=[];
        for($i=0; $i < count($this->keys); $i++) {
            $secondConfig['--'.$this->keys[$i]] = $this->faker->uuid;
        }
        $secondConfig['--file'] = $filename;
        $this->artisan('wp:keys', $secondConfig);
        $content = file_get_contents($this->getPath() . '/'. $filename);
        for($i=0; $i < count($this->keys); $i++) {
            $this->assertContains($this->keys[$i].'="'. $secondConfig['--'.$this->keys[$i]] .'"', $content);
        }

    }

}
