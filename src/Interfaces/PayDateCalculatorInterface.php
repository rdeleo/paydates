<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 16:22
 */

namespace RDeLeo\PayDates\Interfaces;

/**
 * Interface PayDateCalculatorInterface
 *
 * @package RDeLeo\PayDates\Interfaces
 */
interface PayDateCalculatorInterface
{
    /**
     * Return a string with the pay date for that month
     *
     * @param \DateTime $dateTimeObj
     *
     * @return string('YYYY-MM-DD')
     */
    public function calculatePayDate(\DateTime $dateTimeObj) : string ;

    /**
     * Check if the date is valid
     *
     * @return bool
     */
    public function isValidDate() : bool;
}
