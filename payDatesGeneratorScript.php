<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 20/12/16
 * Time: 01:15
 */

require_once __DIR__ . "/vendor/autoload.php";

const BASE_PATH = __DIR__ . '/';
const LOG_PATH = 'logs/app.log';
const LOG_NAME = 'APP';

$payDatesGeneratorObj = new \RDeLeo\PayDates\PayDatesGenerator(
    BASE_PATH,
    LOG_PATH,
    LOG_NAME
);

echo $payDatesGeneratorObj($argv);
