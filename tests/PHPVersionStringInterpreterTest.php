<?php


namespace Jpietrzyk\UsageStatisticsTest;

use Jpietrzyk\UsageStatistics\ValueInterpreter\PHPVersionStringInterpreter;

class PHPVersionStringInterpreterTest extends \PHPUnit_Framework_TestCase
{

    private $fixtures = array(
        '>=5.3.0' => '5.3',
        '>=5.3.2' => '5.3',
        '>=5.5' => '5.5',
        '>=5.3.3' => '5.3',
        '>=5.5.0' => '5.5',
        '~5.5.0' => '5.5',
        '>=5.0' => '5.0',
        '>5.3.3' => '5.3',
        '~5.4' => '5.4',
        '>= 5.3' => '5.3',
        '5.4.*' => '5.4',
        '>=5' => '5.0',
        '>=7.0.0-dev' => '7.0',
        ' >= 5.3' => '5.3',
        '~5.5.0|~5.6.0' => '5.5',
        '>=5.3.3,<5.6' => '5.3',
        '>=5.5.12' => '5.5',
        '^5.4' => '5.4',
        '~5.4 || ~7.0' => '5.4',
        '~5.4.11|~5.5.0' => '5.4',
        '>=5.6.0-dev' => '5.6',
        '>= 5.3.3, <= 5.6.99' => '5.3',
        '5.*' => '5.0',
        '>=5.4.0, <6.0.0' => '5.4',
        '>=5.3,<8.0-DEV' => '5.3',
        '>5.4.1,<7.0' => '5.4',
        '5.*, >=5.4' => '5.0',
        '*' => '0.0',
    );

    /**
     * @var PHPVersionStringInterpreter
     */
    private $interpreter;

    public function setUp()
    {
        $this->interpreter = new PHPVersionStringInterpreter();
    }

    public function testFixtures()
    {
        foreach ($this->fixtures as $value => $expected) {
            $generated = $this->interpreter->getRealValue($value);

            $this->assertTrue($expected === $generated, 'ERROR: "' .  $expected .  '"" != "' . $generated . '"! ("' . $value . '")');
        }
    }
}
