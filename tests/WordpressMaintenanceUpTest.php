<?php
/**
 * Class WordpressMaintenanceUpTest
 */
class WordpressMaintenanceUpTest extends TestCase
{
    public function test_it_has_a_success_response_to_up()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:down', ['--file' => $filename]);
        $this->artisan('wp:up', ['--file' => $filename]);
        $console = $this->consoleOutput();
        $this->assertStringContainsString('Wordpress is back up', $console);

    }

    public function test_it_has_a_up_command_removes_maintenance_file()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:down', ['--file' => $filename]);
        $this->artisan('wp:up', ['--file' => $filename]);
        $this->assertFileDoesNotExist($this->getPublicPath() . '/'. $filename);

    }

    public function test_it_has_removed_the_down_file_without_parameter()
    {
        $this->artisan('wp:down', []);
        $this->artisan('wp:up', []);
        $this->assertFileDoesNotExist($this->getPublicPath() . '/.maintenance');
    }

    public function test_it_has_a_error_response_if_already_up()
    {
        $filename = '.'.$this->faker->uuid;
        $this->artisan('wp:up', ['--file' => $filename]);
        $console = $this->consoleOutput();
        $this->assertStringContainsString('Wordpress is already up', $console);
    }
}
