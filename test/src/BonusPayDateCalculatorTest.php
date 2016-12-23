<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:09
 */

namespace RDeLeo\PayDatesTest;

use RDeLeo\PayDates\BonusPayDateCalculator;

class BonusPayDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    protected $sut;

    protected function setUp()
    {
        $this->sut = new BonusPayDateCalculator();
    }

    public function testSutWillCalculateExpectedPayDate()
    {
        $dateTimeObj = new \DateTime();
        $dateTimeObj->setDate(2016, 12, 1);
        $this->assertEquals(
            '2016-12-12',
            $this->sut->calculatePayDate($dateTimeObj)
        );

        $dateTimeObj->setDate(2016, 11, 1);
        $this->assertEquals(
            '2016-11-15',
            $this->sut->calculatePayDate($dateTimeObj)
        );

        $dateTimeObj->setDate(2016, 6, 1);
        $this->assertEquals(
            '2016-06-14',
            $this->sut->calculatePayDate($dateTimeObj)
        );
    }
}