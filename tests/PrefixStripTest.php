<?php


namespace Jpietrzyk\UsageStatisticsTest;

use Jpietrzyk\UsageStatistics\ValueInterpreter\PrefixStrip;

class PrefixStripTest extends \PHPUnit_Framework_TestCase
{

    public function testFixtures()
    {
        $interpreter = new PrefixStrip('ext-');
        $this->assertEquals('curl', $interpreter->getRealValue('ext-curl'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFixture() {
        $interpreter = new PrefixStrip('ext-');
        $this->assertEquals('test-ext-curl', $interpreter->getRealValue('test-ext-curl'));
    }

   /**
     * @expectedException \InvalidArgumentException
     */
    public function testTooShortFixture() {
        $interpreter = new PrefixStrip('ext-');
        $this->assertEquals('curl', $interpreter->getRealValue('curl'));
    }
}
