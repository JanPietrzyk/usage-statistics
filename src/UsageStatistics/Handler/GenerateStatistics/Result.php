<?php


namespace Jpietrzyk\UsageStatistics\Handler\GenerateStatistics;

use Jpietrzyk\UsageStatistics\Result\RawResult;

/**
 * Class Result
 * @package Jpietrzyk\UsageStatistics\Handler\GenerateStatistics
 */
class Result
{

    /**
     * @var array
     */
    private $result = [];

    /**
     * @param $name
     * @param RawResult $data
     */
    public function add($name, RawResult $data)
    {
        $this->result[$name] = $data;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->result;
    }
}
