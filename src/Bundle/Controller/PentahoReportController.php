<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 */

namespace Optime\PentahoReport\Bundle\Controller;


use Optime\PentahoReport\Lib\ReportBI;

/**
 * @Route("/pentahoreport", name="simplereport_")
 */
class PentahoReportController extends AbstractController
{
    /**
     * @Route("/download", name="index")
     */
    public function index(RequeReportBI $reportBI)
    {

    }

}