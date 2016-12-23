<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 14:23
 */

namespace RDeLeo\PayDatesTestUtility;

use RDeLeo\PayDates\BasicPayDateCalculator;
use RDeLeo\PayDates\BonusPayDateCalculator;
use RDeLeo\PayDates\CliArgumentsEntity;
use RDeLeo\PayDates\CsvFileEntity;
use RDeLeo\PayDates\PayDatesEntity;

trait PayDatesTestHelperTrait
{
    protected $expectedPayDateArray2016 = [
        1 =>
            [
                'date' => '2016-01',
                'basicPayDate' => '2016-01-29',
                'bonusPayDate' => '2016-01-12'
            ],
        2 =>
            [
                'date' => '2016-02',
                'basicPayDate' => '2016-02-29',
                'bonusPayDate' => '2016-02-12'
            ],
        3 =>
            [
                'date' => '2016-03',
                'basicPayDate' => '2016-03-31',
                'bonusPayDate' => '2016-03-15'
            ],
        4 =>
            [
                'date' => '2016-04',
                'basicPayDate' => '2016-04-29',
                'bonusPayDate' => '2016-04-12'
            ],
        5 =>
            [
                'date' => '2016-05',
                'basicPayDate' => '2016-05-31',
                'bonusPayDate' => '2016-05-12'
            ],
        6 =>
            [
                'date' => '2016-06',
                'basicPayDate' => '2016-06-30',
                'bonusPayDate' => '2016-06-14'
            ],
        7 =>
            [
                'date' => '2016-07',
                'basicPayDate' => '2016-07-29',
                'bonusPayDate' => '2016-07-12'
            ],
        8 =>
            [
                'date' => '2016-08',
                'basicPayDate' => '2016-08-31',
                'bonusPayDate' => '2016-08-12'
            ],
        9 =>
            [
                'date' => '2016-09',
                'basicPayDate' => '2016-09-30',
                'bonusPayDate' => '2016-09-12'
            ],
        10 =>
            [
                'date' => '2016-10',
                'basicPayDate' => '2016-10-31',
                'bonusPayDate' => '2016-10-12'
            ],
        11 =>
            [
                'date' => '2016-11',
                'basicPayDate' => '2016-11-30',
                'bonusPayDate' => '2016-11-15'
            ],
        12 =>
            [
                'date' => '2016-12',
                'basicPayDate' => '2016-12-30',
                'bonusPayDate' => '2016-12-12'
            ]
    ];

    protected $dateTimeObj;

    protected $cliArgumentsEntity;

    protected $payDatesEntity;

    protected $csvFileEntity;

    protected function setUpPayDatesEntity()
    {
        $this->dateTimeObj = new \DateTime();
        $this->dateTimeObj->setDate(2016, 1, 1);

        $this->payDatesEntity = new PayDatesEntity(
            $this->dateTimeObj,
            new BasicPayDateCalculator(),
            new BonusPayDateCalculator()
        );
    }

    protected function setUpCliArgumentEntity()
    {
        $this->cliArgumentsEntity = new CliArgumentsEntity();
    }

    protected function setUpCsvFileEntity()
    {
        $this->csvFileEntity = new CsvFileEntity(
            $this->cliArgumentsEntity,
            $this->payDatesEntity,
            __DIR__ . '/../fixtures/'
        );
    }

    /**
     * Call protected/private method of a class.
     * https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}