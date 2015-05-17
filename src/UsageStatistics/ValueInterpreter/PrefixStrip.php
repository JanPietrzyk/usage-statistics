<?php


namespace Jpietrzyk\UsageStatistics\ValueInterpreter;


class PrefixStrip implements ValueInterpreter {

    /**
     * @var string
     */
    private $prefix;

    public function __construct($prefix) {
        $this->prefix = (string) $prefix;
    }

    /**
     * @param string $value
     * @return string
     */
    public function getRealValue($value)
    {
        if(0 !== strpos($value, $this->prefix)) {
            throw new \InvalidArgumentException('Can not strip non existent prefix');
        }

        return substr($value, strlen($this->prefix));
    }
}