<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:10
 */

namespace RDeLeo\PayDatesTest;

use RDeLeo\PayDatesTestUtility\PayDatesTestHelperTrait;

class CsvFileEntityTest extends \PHPUnit_Framework_TestCase
{
    use PayDatesTestHelperTrait;

    protected $sut;

    static protected $expectedFilename;

    static protected $filePath;

    public static function setUpBeforeClass()
    {
        self::$expectedFilename = '2016_PayDates.csv';
        self::$filePath = __DIR__ . '/../fixtures/';

        if (file_exists(self::$filePath . self::$expectedFilename)) {
            unlink(self::$filePath . self::$expectedFilename);
        }
    }

    protected function setUp()
    {
        $this->setUpPayDatesEntity();
        $this->setUpCliArgumentEntity();
        $this->setUpCsvFileEntity();

        $this->sut = $this->csvFileEntity;
    }

    /**
     * @expectedException RDeLeo\PayDates\Exceptions\CsvFileEntityException
     * @expectedExceptionCode 1
     */
    public function testIsWritableCheckWillThrowExpectedException()
    {
        $this->invokeMethod(
            $this->sut,
            'isWritableCheck',
            [__DIR__ . '/../fixtures/NOT_WRITABLE']
        );
    }

    public function testWriteWillWorkAsExpected()
    {
        $this->payDatesEntity->payDatesArray = $this->expectedPayDateArray2016;
        $this->sut->write();

        $this->assertFileExists(self::$filePath . self::$expectedFilename);
        $this->assertEquals(self::$expectedFilename, $this->csvFileEntity->fileName);
    }

    public function testGenerateFileNameWillGenerateARandomFileName()
    {
        $this->cliArgumentsEntity->force = false;
        $this->sut->write();

        $this->assertEquals(
            1,
            preg_match('/2016_(.*)_PayDates.csv/', $this->sut->fileName)
        );
        $this->assertFileExists(self::$filePath . $this->sut->fileName);
        $this->assertTrue(unlink(self::$filePath . $this->sut->fileName));
    }

    public function testWriteWillWorkAsExpectedWithForceOptionEnabled()
    {
        $this->cliArgumentsEntity->force = true;
        $this->setUpCsvFileEntity();
        $this->sut = $this->csvFileEntity;
        $this->payDatesEntity->payDatesArray = $this->expectedPayDateArray2016;
        $this->sut->write();

        $this->assertFileExists(self::$filePath . self::$expectedFilename);
        $this->assertEquals(self::$expectedFilename, $this->csvFileEntity->fileName);
    }

    public function testConstructWillSetTheAssignedFileName()
    {
        $this->cliArgumentsEntity->fileName = 'testName.csv';
        $this->setUpCsvFileEntity();
        $this->sut = $this->csvFileEntity;
        $this->payDatesEntity->payDatesArray = $this->expectedPayDateArray2016;
        $this->sut->write();

        $this->assertEquals(
            $this->cliArgumentsEntity->fileName,
            $this->sut->fileName
        );
        $this->assertFileExists(self::$filePath . $this->cliArgumentsEntity->fileName);
        $this->assertFileEquals(
            self::$filePath . $this->cliArgumentsEntity->fileName,
            self::$filePath . self::$expectedFilename
        );
        $this->assertTrue(unlink(self::$filePath . $this->sut->fileName));
    }
}
