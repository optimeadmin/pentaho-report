<?php

require_once '../vendor/autoload.php';

use Optime\PentahoReport\Lib\ReportBI;

$report = (isset($_GET['report']) && !empty($_GET['report']))?$_GET['report']:null;
$subLocation = (isset($_GET['subfolder']) && !empty($_GET['subfolder']))?$_GET['subfolder'].':':'';

$urlAuth = '';
$baseURI = '';
$biUser = '';
$biPass = '';

$biService = new ReportBI($urlAuth, $baseURI, $biUser, $biPass);

$biService->getBIServerReport($report, $subLocation, $_SERVER['QUERY_STRING']);
