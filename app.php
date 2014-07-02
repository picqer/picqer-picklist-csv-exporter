<?php

ini_set('display_errors', true);
set_time_limit(600);
session_start();

require 'config.php';
require 'vendor/autoload.php';

function dd($content) {
    var_dump($content);
    die();
}

function logThis($message) {
    file_put_contents('sync.log', date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    echo $message . PHP_EOL;
}

use Picqer\Api\Client as PicqerClient;

// Picqer connection
$picqerclient = new PicqerClient($config['picqer-company'], $config['picqer-apikey']);

if (!isset($_GET['step'])) {
    header('Location: app.php?step=upload');
    exit;
}

switch ($_GET['step']) {
    case 'upload':
        include('view-form.php');

        break;

    case 'export':
        if (!isset($_POST['sincedate']) || empty($_POST['sincedate'])) {
            include('view-no-data.php');
            exit;
        }

        $importer = new PicqerExporter\PicklistGetter($picqerclient, $config);
        $picklists = $importer->getClosedPicklistsBetweenIds($_POST['sincedate'], $_POST['startid'], $_POST['endid']);

        $csvBuilder = new PicqerExporter\CsvBuilder($config);
        $csv = $csvBuilder->buildCsv($picklists);

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=export-picqer-picklists-".date('Ymd-His').".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $csv;

        break;
}