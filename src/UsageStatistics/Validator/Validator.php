<?php
namespace Jpietrzyk\UsageStatistics\Validator;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;

/**
 * Class ItemValidator
 *
 * Validate if a certain path exists or has a specific value
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
interface Validator
{
    /**
     * @param ArrayPathFinder $pathFinder
     * @return bool
     */
    public function isValid(ArrayPathFinder $pathFinder);
}
