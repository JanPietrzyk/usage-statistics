<?php


namespace Jpietrzyk\UsageStatisticsTest;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;

class ArrayPathFinderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ArrayPathFinder
     */
    private $pathFinder;

    public function setUp()
    {
        $this->pathFinder = new ArrayPathFinder([
            'test' => [
               'a' => 'a',
                'b' => 'b',
                'c' => 'c',
            ],
            'numbers' => [
                'a',
                'b',
                'c'
            ],
            'complex' => [
                'aaa' => 1,
                'a' => 2,
                'aa' => 3,
                'b' => 4,
            ]
        ]);
    }

    public function testHas()
    {
        $this->assertTrue($this->pathFinder->has('test.a'));
        $this->assertTrue($this->pathFinder->has('numbers.1'));

        $this->assertFalse($this->pathFinder->has('blub'));
        $this->assertFalse($this->pathFinder->has('test.d'));
        $this->assertFalse($this->pathFinder->has('test.a.d'));
    }

    public function testGet()
    {
        $this->assertCount(3, $this->pathFinder->getValue('test'));
        $this->assertCount(3, $this->pathFinder->getValue('numbers'));

        $this->assertEquals('c', $this->pathFinder->getValue('test.c'));
        $this->assertEquals('b', $this->pathFinder->getValue('numbers.1'));

        $this->assertEquals('TOP', $this->pathFinder->getValue('not.found', 'TOP'));
    }

    public function testLike() {
        $this->assertEquals(1, $this->pathFinder->getValue('complex.a*'));
    }
}
