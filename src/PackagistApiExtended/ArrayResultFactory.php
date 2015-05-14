<?php


namespace Jpietrzyk\PackagistApiExtended;

use Packagist\Api\Result\Factory;

/**
 * Class ArrayResultFactory
 *
 * remove dependencies to packagist api
 *
 * @package Jpietrzyk\UsageStatistics\PackagistApiExtended
 */
class ArrayResultFactory extends Factory
{
    public function createPackageResults(array $package)
    {
        return $package;
    }
}
