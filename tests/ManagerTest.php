<?php
/**
 * Class ManagerTest
 */
class ManagerTest extends TestCase
{

    public function tearDown() : void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_it_has_config_key()
    {
        $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $value = $this->faker->uuid;
        $key = $this->faker->uuid;
        $config = [$key => $value];
        $manager = new \Pbc\WordpressArtisan\Manager($filesystemMock, $config);
        $this->assertSame($value, $manager->getConfig($key));
    }

    public function test_it_has_config_keys()
    {
        $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $values = [$this->faker->uuid, $this->faker->uuid];
        $key = [$this->faker->uuid, $this->faker->uuid];
        $config = array_combine($key, $values);
        $manager = new \Pbc\WordpressArtisan\Manager($filesystemMock, $config);
        $this->assertSame($config, $manager->getConfig());
    }

    public function test_it_throws_an_exception_if_the_key_is_missing()
    {
        $this->expectException(Exception::class);
        $filesystemMock = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $values = [$this->faker->uuid, $this->faker->uuid];
        $key = [$this->faker->uuid, $this->faker->uuid];
        $config = array_combine($key, $values);
        $manager = new \Pbc\WordpressArtisan\Manager($filesystemMock, $config);
        $manager->getConfig(time());
    }
}
