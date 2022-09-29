<?php

require_once '/vendor/autoload.php';

use Optime\PentahoReport\Lib\ReportBI;

$report = (isset($_GET['report']) && !empty($_GET['report']))?$_GET['report']:null;
$subFolder = (isset($_GET['subfolder']) && !empty($_GET['subfolder']))?$_GET['subfolder']:'';

$urlAuth = PENTAHO_URL_AUTH;
$baseURI = PENTAHO_BASE_URI;
$biUser = PENTAHO_BI_USER;
$biPass = PENTAHO_BI_PASS;

$ObjReportBI = new ReportBI($urlAuth, $baseURI, $biUser, $biPass);

$ObjReportBI->getBIServerReport($report, $subFolder, $_SERVER['QUERY_STRING']);
