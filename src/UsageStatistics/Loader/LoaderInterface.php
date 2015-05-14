<?php


namespace Jpietrzyk\UsageStatistics\Loader;

interface LoaderInterface
{

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getData($offset, $limit);

    /**
     * @return callable
     */
    public function getGenerator();

    /**
     * @return int
     */
    public function getTotalCount();
}
