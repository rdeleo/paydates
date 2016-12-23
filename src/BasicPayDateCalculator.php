<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 19:55
 */

namespace RDeLeo\PayDates;

/**
 * Class BasicPayDateCalculator
 *
 * @package RDeLeo\PayDates
 */
class BasicPayDateCalculator extends AbstractPayDateCalculator
{
    /**
     * @param \DateTime $dateTimeObj
     *
     * @return string
     */
    public function calculatePayDate(\DateTime $dateTimeObj) : string
    {
        $this->dateTimeObj = clone $dateTimeObj;
        $this->dateTimeObj->setDate(
            $dateTimeObj->format('Y'),
            $dateTimeObj->format('m'),
            $dateTimeObj->format('t')
        );

        while ($this->isValidDate() === false) {
            $this->dateTimeObj->modify('-1 day');
        }

        return $this->dateTimeObj->format('Y-m-d');
    }
}
