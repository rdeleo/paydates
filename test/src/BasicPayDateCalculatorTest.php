<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:08
 */

namespace RDeLeo\PayDatesTest;


use RDeLeo\PayDates\BasicPayDateCalculator;

class BasicPayDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    protected $sut;

    protected function setUp()
    {
        $this->sut = new BasicPayDateCalculator();
    }

    public function testSutWillCalculateExpectedPayDate()
    {
        $dateTimeObj = new \DateTime();
        $dateTimeObj->setDate(2016, 12, 1);
        $this->assertEquals(
            '2016-12-30',
            $this->sut->calculatePayDate($dateTimeObj)
        );

        $dateTimeObj->setDate(2016, 10, 1);
        $this->assertEquals(
            '2016-10-31',
            $this->sut->calculatePayDate($dateTimeObj)
        );

        $dateTimeObj->setDate(2015, 2, 1);
        $this->assertEquals(
            '2015-02-27',
            $this->sut->calculatePayDate($dateTimeObj)
        );
    }
}