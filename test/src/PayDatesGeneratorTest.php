<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 01:19
 */

namespace RDeLeo\PayDatesTest;

use RDeLeo\PayDates\CliHelperTrait;
use RDeLeo\PayDates\PayDatesGenerator;

class PayDatesGeneratorTest extends \PHPUnit_Framework_TestCase
{
    use CliHelperTrait;

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

    public function testInvokeWillReturnHelpMessage()
    {
        $sut = new PayDatesGenerator(
            self::$filePath,
            '../../../logs/test.log',
            'TEST'
        );

        $this->assertEquals(
            $this->getHelp(),
            $sut([
                0 => 'script.php',
                1 => '-h'
            ])
        );
    }

    public function testInvokeWillWorkAsExpected()
    {
        $sut = new PayDatesGenerator(
            self::$filePath,
            '../../logs/test.log',
            'TEST'
        );

        $this->assertEquals(
            $this->getSuccess(self::$expectedFilename),
            $sut([
                0 => 'script.php',
                1 => '-y',
                2 => 2016
            ])
        );
    }

    public function testInvokeWillGetExpectedErrorMessage()
    {
        $sut = new PayDatesGenerator(
            self::$filePath,
            '../../logs/test.log',
            'TEST'
        );

        $this->assertEquals(
            $this->getErrorWithMessage(self::$filePath . 'NOT_WRITABLE is not writable.'),
            $sut([
                0 => 'script.php',
                1 => '-f',
                2 => 'NOT_WRITABLE'
            ])
        );
    }

    public function testInvokeWillGetExpectedInvalidOptionMessage()
    {
        $sut = new PayDatesGenerator(
            self::$filePath,
            '../../logs/test.log',
            'TEST'
        );

        $this->assertEquals(
            $this->getInvalidOption('-X'),
            $sut([
                0 => 'script.php',
                1 => '-X'
            ])
        );

        $sut = new PayDatesGenerator(
            self::$filePath,
            '../../logs/test.log',
            'TEST'
        );

        $this->assertEquals(
            $this->getInvalidOption('Year mandatory format : \'YYYY\''),
            $sut([
                0 => 'script.php',
                1 => '--year',
                2 => 0
            ])
        );
    }

    public function testInvokeWillGetExpectedError()
    {
        $sut = new PayDatesGenerator(
            '',
            '',
            'TEST'
        );

        $this->assertEquals(
            $this->getError(),
            $sut([
                0 => 'script.php',
                1 => '-f',
                2 => 'NOT_WRITABLE',
                3 => '-F'
            ])
        );
    }
}