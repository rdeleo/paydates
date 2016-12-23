<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 20:14
 */

namespace RDeLeo\PayDates;

use RDeLeo\PayDates\Interfaces\PayDateCalculatorInterface;

/**
 * Class AbstractPayDateCalculator
 *
 * @package RDeLeo\PayDates
 */
abstract class AbstractPayDateCalculator implements PayDateCalculatorInterface
{
    /**
     * @var \DateTime
     */
    protected $dateTimeObj;

    /**
     * @return bool
     */
    public function isValidDate() : bool
    {
        return ($this->dateTimeObj->format('w') == 0 || $this->dateTimeObj->format('w') == 6) ? false : true;
    }
}
