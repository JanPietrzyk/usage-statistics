<?php


namespace Jpietrzyk\UsageStatistics\Calculator;
use Jpietrzyk\UsageStatistics\Result\RawResultInterface;
use Jpietrzyk\UsageStatistics\Result\CalculatedResultItem;
use Jpietrzyk\UsageStatistics\Result\RawResultItem;

/**
 * Class Calculator
 * @package Jpietrzyk\UsageStatistics\Calculator
 */
class Calculator {

    /**
     * @var RawResultInterface
     */
    private $rawResult;

    /**
     * @var int
     */
    private $combineUnder;

    /**
     * @var int
     */
    private $invalidPercentage;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var int
     */
    private $precision;

    /**
     * @param RawResultInterface $rawResult
     * @param Precision $precision
     * @param int $combineUnder
     */
    public function __construct(RawResultInterface $rawResult, Precision $precision, $combineUnder = 5) {
        $this->rawResult = $rawResult;
        $this->combineUnder = (int) $combineUnder;
        $this->precision = $precision;

        $this->caclculateInvalidPercentage();
        $this->calculateResult();
    }

    /**
     * @return int
     */
    public function getInvalidPercentage()
    {
        return $this->invalidPercentage;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     *
     */
    private function calculateResult()
    {
        $this->totalCount = $this->rawResult->getTotalCount();

        /** @var CalculatedResultItem[] $stock */
        $stock = [];

        foreach($this->rawResult->getResultItems() as $rawResultItem) {
            $rawPercentage = ($rawResultItem->getNumberOfOccurrences() / $this->totalCount) * 100;

            if($rawPercentage < $this->combineUnder) {
                $stock[] = new CalculatedResultItem($rawPercentage, $this->precision, $rawResultItem);
                continue;
            }

            $this->result[] = new CalculatedResultItem($rawPercentage, $this->precision, $rawResultItem);
        }

        if(count($stock)) {
            $this->result[] = $this->combineStock($stock);
        }
    }

    /**
     * @param CalculatedResultItem[] $stock
     * @return CalculatedResultItem
     */
    private function combineStock(array $stock) {
        $names = [];
        $percentage = 0;
        $count = 0;

        foreach($stock as $stockItem) {
            $percentage += $stockItem->getRawPercentage();
            $names[] = $stockItem->getName();
            $count += $stockItem->getNumberOfOccurrences();
        }

        return new CalculatedResultItem(
            $percentage,
            $this->precision,
            new RawResultItem(
                implode(', ', $names),
                $count
            )
        );
    }

    private function caclculateInvalidPercentage()
    {
        $invalidCnt = $this->rawResult->getInvalidCount();

        if(!$invalidCnt) {
            $this->invalidPercentage = 0;
            return;
        }

        $rawInvalidPercentage = $invalidCnt / $this->rawResult->getTotalCount() * 100;
        $roundedInvalidPercentage = round($rawInvalidPercentage, $this->precision->getPrecision());

        $this->invalidPercentage = $this->precision->formatValue($roundedInvalidPercentage);

    }


}