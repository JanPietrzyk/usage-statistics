<?php


namespace Jpietrzyk\UsageStatistics\ValueInterpreter;

/**
 * Class NumericValueInterpreter
 *
 * Strip php version strings to a minimum
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class PHPVersionStringInterpreter implements ValueInterpreter
{

    /**
     * Will implode strings
     *
     * @var array
     */
    private $orSigns = [
        '|',
        ','
    ];

    /**
     * will be removed
     *
     * @var array
     */
    private $signsToStrip = [
        '>',
        '<',
        '=',
        '~',
        '^',
        '@dev',
    ];

    /**
     * @param string $value
     * @return string
     */
    public function getRealValue($value)
    {
        $value = $this->stripUninterpretedSigns($value);

        $numbers = $this->explodeOrCondition($value);

        $value = array_shift($numbers);

        $value = $this->stripLastDecimals($value);

        return trim($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    private function stripLastDecimals($value)
    {
        $parts = explode('.', $value);

        $realParts = array_splice($parts, 0, 2);

        if (count($realParts) == 1) {
            $realParts[] = '0';
        }

        return str_replace('*', '0', implode('.', $realParts));
    }

    /**
     * @param $value
     * @return array
     */
    private function explodeOrCondition($value)
    {
        $ret = [];

        foreach ($this->orSigns as $orSign) {
            $ret = explode($orSign, $value);

            if (count($ret) > 1) {
                return $ret;
            }
        }

        return $ret;
    }

    /**
     * @param $value
     * @return string
     */
    private function stripUninterpretedSigns($value)
    {
        foreach ($this->signsToStrip as $signToStrip) {
            $value = str_replace($signToStrip, '', $value);
        }

        return trim($value);
    }
}
