<?php


namespace Jpietrzyk\UsageStatisticsTest\Collection;

use Jpietrzyk\UsageStatistics\Loader\FileLoader;

class FileLoaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FileLoader
     */
    private $fileLoader;

    public function setUp()
    {
        $this->fileLoader = new FileLoader(__DIR__ . '/FileFixtures/');
    }

    public function testCount()
    {
        $this->assertEquals(12, $this->fileLoader->getTotalCount());
    }

    public function testElements()
    {
        $result = $this->fileLoader->getData(0, 200);

        $this->assertCount(12, $result);
    }
}
