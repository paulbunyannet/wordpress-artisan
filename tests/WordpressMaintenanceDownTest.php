<?php

use Pbc\WordpressArtisan\Commands\Wordpress\Maintenance\Generate;

/**
 * Class WordpressMaintenanceDownTest
 */
class WordpressMaintenanceDownTest extends TestCase
{
    public function test_it_has_a_success_response_to_down()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:down', ['--file' => $filename]);
        $console = $this->consoleOutput();
        $this->assertStringContainsString('Wordpress set to maintenance mode.', $console);
    }

    public function test_it_has_created_the_down_file()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:down', ['--file' => $filename]);
        $this->assertFileExists($this->getPublicPath() . '/'. $filename);
    }

    public function test_it_has_created_the_down_file_without_parameter()
    {
        $this->artisan('wp:down', []);
        $this->assertFileExists($this->getPublicPath() . '/.maintenance');
    }

    public function test_it_has_created_the_down_file_in_a_specific_directory()
    {
        $filename = '.'.$this->faker->uuid;
        $dir = time();
        $this->artisan('wp:down', ['--file' => $filename, '--dir' => $dir]);
        $this->assertFileExists($this->getPublicPath() . '/' . $dir . '/' . $filename);
    }

    public function test_it_returns_error_if_already_down()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:down', ['--file' => $filename]);
        $this->artisan('wp:down', ['--file' => $filename]);
        $console = $this->consoleOutput();
        $this->assertStringContainsString('Wordpress is already down', $console);

    }

    public function test_it_has_the_same_content_as_the_maintenance_template()
    {
        $filename = '.'.$this->faker->uuid;
        $dir = time();
        $this->artisan('wp:down', ['--file' => $filename, '--dir' => $dir]);
        $this->assertSame(
            file_get_contents($this->getPublicPath() . '/' . $dir . '/' . $filename),
            Generate::getTemplateContent()
        );
    }
}
