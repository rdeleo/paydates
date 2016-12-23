<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 20:16
 */

namespace RDeLeo\PayDates;

/**
 * Class BonusPayDateCalculator
 *
 * @package RDeLeo\PayDates
 */
class BonusPayDateCalculator extends AbstractPayDateCalculator
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
            12
        );

        if ($this->isValidDate() === true) {
            return $this->dateTimeObj->format('Y-m-d');
        }

        while ($this->dateTimeObj->format('w') != 2) {
            $this->dateTimeObj->modify('+1 day');
        }

        return $this->dateTimeObj->format('Y-m-d');
    }
}
