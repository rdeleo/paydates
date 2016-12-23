<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:10
 */

namespace RDeLeo\PayDatesTest;

use RDeLeo\PayDatesTestUtility\PayDatesTestHelperTrait;

class PayDatesEntityTest extends \PHPUnit_Framework_TestCase
{
    use PayDatesTestHelperTrait;

    protected $sut;

    protected function setUp()
    {
        $this->setUpPayDatesEntity();

        $this->sut = $this->payDatesEntity;
    }

    public function testGeneratePayDatesArrayWillWorkAsExpected()
    {
        $this->sut->generatePayDatesArray();

        $this->assertEquals(
            $this->expectedPayDateArray2016,
            $this->sut->payDatesArray
        );
    }
}