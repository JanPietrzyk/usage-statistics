<?php
namespace Jpietrzyk\UsageStatistics;


/**
 * Class ArrayPathFinder
 *
 * Get  values from path strings like x.y.z
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
interface PathFinder
{
    const WILDCARD = '*';

    /**
     * @param $path
     * @return bool
     */
    public function has($path);

    /**
     * @param $path
     * @param null $default
     * @return array|null
     */
    public function getValue($path, $default = null);

    /**
     * @param $path
     * @return mixed
     */
    public function requireValue($path);
}