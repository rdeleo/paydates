<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 16:18
 */

namespace RDeLeo\PayDates;

use RDeLeo\PayDates\Interfaces\PayDateCalculatorInterface;

/**
 * Class PayDatesEntity
 *
 * @package RDeLeo\PayDates
 */
class PayDatesEntity
{
    /**
     * @var array
     */
    public $payDatesArray = [];

    /**
     * @var \DateTime
     */
    public $dateTimeObj;

    /**
     * @var PayDateCalculatorInterface
     */
    protected $basicCalculator;

    /**
     * @var PayDateCalculatorInterface
     */
    protected $bonusCalculator;

    /**
     * PayDatesEntity constructor.
     *
     * @param \DateTime $dateTimeObj
     * @param PayDateCalculatorInterface $basicCalculator
     * @param PayDateCalculatorInterface $bonusCalculator
     */
    public function __construct(
        \DateTime $dateTimeObj,
        PayDateCalculatorInterface $basicCalculator,
        PayDateCalculatorInterface $bonusCalculator
    ) {
        $this->dateTimeObj = $dateTimeObj;
        $this->basicCalculator = $basicCalculator;
        $this->bonusCalculator = $bonusCalculator;
    }

    /**
     * Generate pay dates array
     *
     * @return bool
     */
    public function generatePayDatesArray() : bool
    {
        for ($month = 1; $month <= 12; $month++) {
            $this->dateTimeObj->setDate(
                $this->dateTimeObj->format('Y'),
                $month,
                1
            );

            $this->payDatesArray[$month] = [
                'date' => $this->dateTimeObj->format('Y-m'),
                'basicPayDate' => $this->basicCalculator->calculatePayDate($this->dateTimeObj),
                'bonusPayDate' => $this->bonusCalculator->calculatePayDate($this->dateTimeObj)
            ];
        }

        return true;
    }
}
