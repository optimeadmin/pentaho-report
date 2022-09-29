<?php
/**
 * Created by PhpStorm.
 * User: Oscar
 */

namespace Optime\PentahoReport\Bundle\Controller;


use Optime\PentahoReport\Bundle\Service\ReportService;
use Optime\PentahoReport\Lib\ReportBI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pentahoreport", name="pentahoreport_")
 */
class PentahoReportController extends AbstractController
{
    /**
     * @Route("/download", name="index")
     */
    public function index(Request $request, ReportService $reportService)
    {
        $report = $request->query->get('report');
        $subfolder = $request->query->get('subfolder');
        $reportParams = $request->getQueryString();

        return $reportService->downloadReport($report, $subfolder, $reportParams);
    }

}