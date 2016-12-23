<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:10
 */

namespace RDeLeo\PayDatesTest;

use RDeLeo\PayDates\CliArgumentsEntity;

class CliArgumentsEntityTest extends \PHPUnit_Framework_TestCase
{
    protected $sut;

    protected function setUp()
    {
        $this->sut = new CliArgumentsEntity();
    }

    /**
     * @expectedException RDeLeo\PayDates\Exceptions\CliArgumentsEntityException
     * @expectedExceptionMessage Year mandatory format : 'YYYY'
     */
    public function testCheckYearWillThrowTheExpectedException()
    {
        $this->sut->checkYear(0);
    }

    /**
     * @expectedException RDeLeo\PayDates\Exceptions\CliArgumentsEntityException
     * @expectedExceptionMessage -G
     */
    public function testSetArgumentsWillThrowTheExpectedException()
    {
        $failedArray = [
            0 => 'script.php',
            1 => '-G'
        ];
        $this->sut->setArguments($failedArray);
    }

    public function testSetArgumentsWillWorkAsExpected()
    {
        $correctArray = [
            0 => 'script.php',
            1 => '-h',
            2 => '-y',
            3 => 2013,
            4 => '-f',
            5 => 'fileName.csv',
            6 => '-F'
        ];
        $this->sut->setArguments($correctArray);

        $this->assertTrue($this->sut->isHelp);
        $this->assertEquals(
            $correctArray[3],
            $this->sut->year
        );
        $this->assertEquals(
            $correctArray[5],
            $this->sut->fileName
        );
        $this->assertTrue($this->sut->force);

        $this->setUp();
        $correctArray = [
            0 => 'script.php',
            1 => '-h',
            2 => '-y',
            3 => 2011,
            6 => '-F'
        ];
        $this->sut->setArguments($correctArray);

        $this->assertTrue($this->sut->isHelp);
        $this->assertEquals(
            $correctArray[3],
            $this->sut->year
        );
        $this->assertEquals('', $this->sut->fileName);
        $this->assertFalse($this->sut->force);

        $this->setUp();
        $correctArray = [
            0 => 'script.php',
            1 => '-h',
            2 => '-f',
            3 => 'testFileName.csv'
        ];
        $this->sut->setArguments($correctArray);

        $this->assertTrue($this->sut->isHelp);
        $this->assertFalse($this->sut->year);
        $this->assertEquals(
            $correctArray[3],
            $this->sut->fileName
        );
        $this->assertFalse($this->sut->force);
    }
}