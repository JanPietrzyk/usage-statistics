<?php


namespace Jpietrzyk\UsageStatistics\Result;


class RawResultItem implements RawResultItemInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $numberOfOccurrences;

    /**
     * @param string $name
     * @param int $numberOfOccurrences
     */
    public function __construct($name, $numberOfOccurrences) {
        $this->name = (string) $name;
        $this->numberOfOccurrences = (int) $numberOfOccurrences;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getNumberOfOccurrences()
    {
        return $this->numberOfOccurrences;
    }



}