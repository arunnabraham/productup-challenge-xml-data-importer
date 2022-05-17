<?php

use Arunnabraham\XmlDataImporter\Commands\XMLImportExportCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;



require_once __DIR__ . '/../vendor/autoload.php';

/** LOAD ENV CONFIG **/
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

if (env('APP_MODE') === 'prod') {
    error_reporting(0);
}


/** LOAD CONSOLE APP **/
$app = new Application();
$app->add(new XMLImportExportCommand());
$app->run();
