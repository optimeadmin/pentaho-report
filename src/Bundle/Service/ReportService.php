<?php


namespace Optime\PentahoReport\Bundle\Service;


use Optime\PentahoReport\Lib\ReportBI;

class ReportService
{
    /**
     * @var ReportBI
     */
    private ReportBI $reportBI;

    /**
     * ReportService constructor.
     * @param ReportBI $reportBI
     */
    public function __construct(ReportBI $reportBI)
    {
        $this->reportBI = $reportBI;
    }

    public function downloadReport($report, $subfolder, $reportParams)
    {
        $this->reportBI->getBIServerReport($report, $subfolder, $reportParams);
    }
}