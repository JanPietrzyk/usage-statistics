<?php


namespace Jpietrzyk\UsageStatistics;

use Jpietrzyk\UsageStatistics\Validator\ItemValidator;
use Jpietrzyk\UsageStatistics\ValueInterpreter\ValueInterpreter;

/**
 * Class Counter
 *
 * Count and add values to lists
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class Counter
{

    /**
     * If the given path was not found in array
     */
    const NOT_FOUND_KEY = '_NOT_FOUND_';

    /**
     * @var array
     */
    private $values = [
        self::NOT_FOUND_KEY => 0
    ];

    /**
     * @var int
     */
    private $totalCount = 0;

    /**
     * @var int
     */
    private $inavlidCount = 0;

    /**
     * @var
     */
    private $path;

    /**
     * @var ItemValidator[]
     */
    private $validators = [];

    /**
     * @var ValueInterpreter
     */
    private $interpreter;

    /**
     * @var ListCollector
     */
    private $listCollectors = [];

    /**
     * @param $path
     * @param array $validators
     * @param ValueInterpreter $interpreter
     * @param array $listCollector
     */
    public function __construct($path, array $validators, ValueInterpreter $interpreter, array $listCollector)
    {
        $this->path = $path;
        $this->setValidators($validators);
        $this->interpreter = $interpreter;
        $this->setListCollectors($listCollector);
    }

    /**
     * @param array $validators
     */
    public function setValidators(array $validators)
    {
        foreach ($validators as $filter) {
            $this->addValidator($filter);
        }
    }

    /**
     * @param ItemValidator $validator
     */
    public function addValidator(ItemValidator $validator)
    {
        $this->validators[] = $validator;
    }

    /**
     * @param array $listCollectors
     */
    public function setListCollectors(array $listCollectors)
    {
        foreach ($listCollectors as $listCollector) {
            $this->addListCollector($listCollector);
        }
    }

    /**
     * @param ListCollector $collector
     */
    public function addListCollector(ListCollector $collector)
    {
        $this->listCollectors[] = $collector;
    }

    /**
     * @param ArrayPathFinder $pathFinder
     * @return bool
     */
    public function inspect(ArrayPathFinder $pathFinder)
    {
        if (!$this->isValid($pathFinder)) {
            return false;
        }

        try {
            $value = $pathFinder->requireValue($this->path);
        } catch (\InvalidArgumentException $e) {
            $this->setNotFound();
            ;
            return false;
        }


        $this->storeValue($value, $pathFinder);
        return true;
    }

    /**
     * @param ArrayPathFinder $pathFinder
     * @return bool
     */
    private function isValid(ArrayPathFinder $pathFinder)
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($pathFinder)) {
                $this->inavlidCount++;
                return false;
            }
        }

        return true;
    }

    /**
     * @param $value
     * @param ArrayPathFinder $pathFinder
     */
    private function storeValue($value, ArrayPathFinder $pathFinder)
    {
        $filteredValue = $this->interpreter->getRealValue($value);

        if (!isset($this->values[$filteredValue])) {
            $this->values[$filteredValue] = 0;
        }

        $this->values[$filteredValue]++;

        $this->notifyListCollectors($filteredValue, $pathFinder);

        $this->totalCount++;
    }

    /**
     * @param $filteredValue
     * @param ArrayPathFinder $pathFinder
     */
    private function notifyListCollectors($filteredValue, ArrayPathFinder $pathFinder)
    {
        foreach ($this->listCollectors as $listCollector) {
            $listCollector->inspectAs($filteredValue, $pathFinder);
        }
    }

    private function setNotFound()
    {
        $this->values[self::NOT_FOUND_KEY]++;
    }

    /**
     * @return array
     */
    public function getArrayResult()
    {
        $collectorsResult = [];

        foreach ($this->listCollectors as $listCollector) {
            $collectorsResult[] = $listCollector->getArrayResult();
        }

        return [
            'total' => $this->totalCount,
            'invalid' => $this->inavlidCount,
            'countResult' => $this->values,
            'listResult' => $collectorsResult,
        ];
    }
}
