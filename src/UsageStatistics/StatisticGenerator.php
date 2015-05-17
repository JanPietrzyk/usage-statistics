<?php


namespace Jpietrzyk\UsageStatistics;

use Jpietrzyk\UsageStatistics\Counter\CounterInterface;
use Jpietrzyk\UsageStatistics\Counter\ResultSet;
use Jpietrzyk\UsageStatistics\Result\RawResult;
use Jpietrzyk\UsageStatistics\Result\RawResultItem;
use Jpietrzyk\UsageStatistics\Validator\ItemValidator;

class StatisticGenerator {

    /**
     * @var CounterInterface
     */
    private $counter;

    /**
     * @var ResultSet
     */
    private $resultSet;

    /**
     * @var ItemValidator[]
     */
    private $validators = [];

    /**
     * @var ListCollector[]
     */
    private $listCollectors = [];

    private $inspectionCount = 0;

    /**
     * @param CounterInterface $counter
     * @param array $validators
     * @param array $listCollector
     */
    public function __construct(CounterInterface $counter, array $validators, array $listCollector = [])
    {
        $this->counter = $counter;

        $this->setValidators($validators);
        $this->setListCollectors($listCollector);

        $this->resultSet = new ResultSet();
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
     */
    public function inspect(ArrayPathFinder $pathFinder)
    {
        $this->resultSet->resetModified();

        if (!$this->isValid($pathFinder)) {
            $this->resultSet->setInvalid();
        }

        $this->counter->inspect($pathFinder, $this->resultSet);

        foreach($this->resultSet->getModified() as $value) {
           $this->notifyListCollectors($value, $pathFinder);
        }

        $this->inspectionCount++;
    }

    /**
     * @param ArrayPathFinder $pathFinder
     * @return bool
     */
    private function isValid(ArrayPathFinder $pathFinder)
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($pathFinder)) {
                return false;
            }
        }

        return true;
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

    /**
     * @return RawResult
     */
    public function getRawResult()
    {
        $result = new RawResult($this->inspectionCount, $this->resultSet->getInvalidCount());

        foreach ($this->listCollectors as $listCollector) {

            $result->addListCollection($listCollector->getRawResult());
        }

        foreach($this->resultSet->getValues() as $name => $value) {
            $result->addResultItem(new RawResultItem($name, $value));
        }

        return $result;
    }
}