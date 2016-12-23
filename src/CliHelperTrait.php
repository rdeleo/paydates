<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 00:52
 */

namespace RDeLeo\PayDates;

/**
 * Trait CliHelperTrait
 *
 * @package RDeLeo\PayDates
 */
trait CliHelperTrait
{
    /**
     * @return string
     */
    public function getHelp() : string
    {
        $result = "\n\r";
        $result .= "Usage: php payDatesGenerator.php [OPTION]... \n\r";
        $result .= "Calculate standard and bonus pay dates and save into csv file.\n\r";
        $result .= "\n\r";
        $result .= "  -h, --help            print this help\n\r";
        $result .= "  -y, --year=YEAR       set year, mandatory format 'YYYY'\n\r";
        $result .= "  -f, --file=FILE_NAME  set filename to save\n\r";
        $result .= "  -F, --force           override if file exists\n\r";

        return $result;
    }

    /**
     * @param string $invalidOption
     *
     * @return string
     */
    public function getInvalidOption(string $invalidOption) : string
    {
        $result = "\n\r";
        $result .= "php payDatesGeneratorScript.php: invalid option -- '" . $invalidOption . "' \n\r";
        $result .= "Try 'php payDatesGeneratorScript.php --help' for more information.\n\r";

        return $result;
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    public function getSuccess(string $fileName) : string
    {
        $result = "\n\r";
        $result .= "php payDatesGeneratorScript.php: csv successfully generated.\n\r";
        $result .= "Filename: '" . $fileName . "' \n\r";

        return $result;
    }

    /**
     * @return string
     */
    public function getError() : string
    {
        $result = "\n\r";
        $result .= "php payDatesGeneratorScript.php: unexpected error\n\r";
        $result .= "Check the log for more information.\n\r";

        return $result;
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public function getErrorWithMessage(string $message) : string
    {
        $result = "\n\r";
        $result .= "php payDatesGeneratorScript.php error: " . $message . "\n\r";
        $result .= "Check the log for more information.\n\r";

        return $result;
    }
}