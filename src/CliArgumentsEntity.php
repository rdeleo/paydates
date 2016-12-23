<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 19/12/16
 * Time: 20:44
 */

namespace RDeLeo\PayDates;

use RDeLeo\PayDates\Exceptions\CliArgumentsEntityException;

/**
 * Class CliArgumentsEntity
 *
 * @package RDeLeo\PayDates
 */
class CliArgumentsEntity
{
    /**
     * @var bool
     */
    public $isHelp = false;

    /**
     * @var bool|int
     */
    public $year = false;

    /**
     * @var string
     */
    public $fileName = '';

    /**
     * @var bool
     */
    public $force = false;

    /**
     * @var array
     */
    protected $argv;

    /**
     * @param array $argv
     *
     * @return bool
     *
     * @throws CliArgumentsEntityException
     */
    public function setArguments(array $argv) : bool
    {
        $this->argv = $argv;
        $argumentIndex = 1;

        while (isset($argv[$argumentIndex])) {
            $argumentIndex = $this->checkArguments($argumentIndex);
        }

        return true;
    }

    /**
     * @param int $year
     *
     * @throws CliArgumentsEntityException
     */
    public function checkYear(int $year)
    {
        if ($year <= 0) {
            throw new CliArgumentsEntityException(
                "Year mandatory format : 'YYYY'",
                2
            );
        }
    }

    /**
     * @param int $argumentIndex
     *
     * @return int
     *
     * @throws CliArgumentsEntityException
     */
    protected function checkArguments(int $argumentIndex) : int
    {
        if ($this->argv[$argumentIndex] === '-h' || $this->argv[$argumentIndex] === '--help') {
            $this->isHelp = true;
            $argumentIndex++;
            return $argumentIndex;
        }

        if ($this->argv[$argumentIndex] === '-y' || $this->argv[$argumentIndex] === '--year') {
            $argumentIndex++;
            $this->checkYear($this->argv[$argumentIndex]);
            $this->year = $this->argv[$argumentIndex];
            $argumentIndex++;
            return $argumentIndex;
        }

        if ($this->argv[$argumentIndex] === '-f' || $this->argv[$argumentIndex] === '--file') {
            $argumentIndex++;
            $this->fileName = $this->argv[$argumentIndex];
            $argumentIndex++;
            return $argumentIndex;
        }

        if ($this->argv[$argumentIndex] === '-F' || $this->argv[$argumentIndex] === '--force') {
            $this->force = true;
            $argumentIndex++;
            return $argumentIndex;
        }

        throw new CliArgumentsEntityException($this->argv[$argumentIndex], 1);
    }
}


