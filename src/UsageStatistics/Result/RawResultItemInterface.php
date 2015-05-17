<?php
namespace Jpietrzyk\UsageStatistics\Result;

interface RawResultItemInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getNumberOfOccurrences();
}