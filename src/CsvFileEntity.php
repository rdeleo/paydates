<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 20:43
 */

namespace RDeLeo\PayDates;

use RDeLeo\PayDates\Exceptions\CsvFileEntityException;

/**
 * Class CsvFileEntity
 *
 * @package RDeLeo\PayDates
 */
class CsvFileEntity
{
    /**
     * @var string
     */
    public $fileName;

    /**
     * @var string
     */
    public $filePath;

    /**
     * @var CliArgumentsEntity
     */
    protected $cliArgumentsEntity;

    /**
     * @var PayDatesEntity
     */
    protected $payDatesEntity;

    /**
     * CsvFileEntity constructor.
     *
     * @param CliArgumentsEntity $cliArgumentsEntity
     * @param PayDatesEntity $payDatesEntity
     * @param string $filePath
     */
    public function __construct(
        CliArgumentsEntity $cliArgumentsEntity,
        PayDatesEntity $payDatesEntity,
        string $filePath
    ) {
        $this->cliArgumentsEntity = $cliArgumentsEntity;
        $this->payDatesEntity = $payDatesEntity;

        $this->isWritableCheck($filePath);
        $this->filePath = $filePath;

        $this->fileName = (empty($this->cliArgumentsEntity->fileName))
            ? $this->generateFileName()
            : $this->cliArgumentsEntity->fileName;
    }

    /**
     *  Write CSV
     */
    public function write()
    {
        if (file_exists($this->filePath . $this->fileName)) {
            $this->isWritableCheck($this->filePath . $this->fileName);

            if ($this->cliArgumentsEntity->force === true) {
                unlink($this->filePath . $this->fileName);
            }
        }

        $file = fopen($this->filePath . $this->fileName, "w");

        foreach ($this->payDatesEntity->payDatesArray as $payDatesRow) {
            fputcsv($file, $payDatesRow);
        }
        
        fclose($file);
    }

    /**
     * @param $filePathName
     *
     * @return bool
     *
     * @throws CsvFileEntityException
     */
    protected function isWritableCheck($filePathName)
    {
        if (!is_writable($filePathName)) {
            throw new CsvFileEntityException($filePathName." is not writable.", 1);
        }

        return true;
    }

    /**
     * @return string
     */
    protected function generateFileName() : string
    {
        $fileNameTmp = $this->payDatesEntity->dateTimeObj->format('Y') . "_PayDates.csv";

        if (!file_exists($this->filePath . $fileNameTmp)) {
            return $fileNameTmp;
        }

        if ($this->cliArgumentsEntity->force === true) {
            return $fileNameTmp;
        }

        return $this->payDatesEntity->dateTimeObj->format('Y') . "_" .
            md5(time() . random_int(0, time())) .
            "_PayDates.csv";
    }
}
