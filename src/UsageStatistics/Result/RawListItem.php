<?php


namespace Jpietrzyk\UsageStatistics\Result;

class RawListItem implements RawListItemInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($name, $value)
    {
        $this->name = (string) $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
