<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 01:11
 */

namespace RDeLeo\PayDates;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use RDeLeo\PayDates\Exceptions\CliArgumentsEntityException;
use RDeLeo\PayDates\Exceptions\CsvFileEntityException;

/**
 * Class PayDatesGenerator
 *
 * This is an Assembler-Builder to generate pay days csv
 *
 * @package RDeLeo\PayDates
 */
class PayDatesGenerator
{
    use CliHelperTrait;

    /**
     * @var CliArgumentsEntity
     */
    protected $cliArgumentsEntity;

    /**
     * @var CsvFileEntity
     */
    protected $csvFileEntity;

    /**
     * @var PayDatesEntity
     */
    protected $payDatesEntity;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var bool
     */
    protected $controllerError = false;

    /**
     * PayDatesGenerator constructor.
     *
     * @param string $basePath
     * @param string $logPath
     * @param string $logName
     */
    public function __construct(
        string $basePath,
        string $logPath,
        string $logName
    ) {
        try {
            if (empty($basePath)) {
                throw new \Exception("Empty basePath", 1);
            }
            $this->basePath = $basePath;

            $this->logger = new Logger($logName);
            $this->logger->pushHandler(
                new StreamHandler($basePath . $logPath)
            );
        } catch (\Throwable $e) {
            $this->controllerError = true;
        }
    }

    /**
     * @return string
     *
     * @param array $argv
     */
    public function __invoke(array $argv = []) : string
    {
        try {
            if ($this->controllerError) {
                return $this->getError();
            }

            $this->cliArgumentsEntity = new CliArgumentsEntity();
            $this->cliArgumentsEntity->setArguments($argv);

            if ($this->cliArgumentsEntity->isHelp === true) {
                return $this->getHelp();
            }

            $dateTimeObj = new \DateTime();

            if ($this->cliArgumentsEntity->year) {
                $dateTimeObj->setDate($this->cliArgumentsEntity->year, 1, 1);
            }

            $this->payDatesEntity = new PayDatesEntity(
                $dateTimeObj,
                new BasicPayDateCalculator(),
                new BonusPayDateCalculator()
            );

            $this->csvFileEntity = new CsvFileEntity(
                $this->cliArgumentsEntity,
                $this->payDatesEntity,
                $this->basePath
            );

            $this->payDatesEntity->generatePayDatesArray();
            $this->csvFileEntity->write();

            return $this->getSuccess($this->csvFileEntity->fileName);
        } catch (CliArgumentsEntityException $e) {
            return $this->getInvalidOption($e->getMessage());
        } catch (CsvFileEntityException $e) {
            $this->logError($e);
            return $this->getErrorWithMessage($e->getMessage());
        } catch (\Throwable $e) {
            $this->logError($e);
            return $this->getError();
        }
    }

    /**
     * @param \Throwable $error
     *
     * @return bool
     */
    protected function logError(\Throwable $error) : bool
    {
        return $this->logger->error("PayDatesGenerator - ". get_class($error) ." - File: " . $error->getFile() .
            " - Line: " . $error->getLine() . " - Code: " . $error->getCode() . " - Message: " . $error->getMessage() .
            " - Trace: " . $error->getTraceAsString());
    }
}
