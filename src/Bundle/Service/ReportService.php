<?php

namespace Optime\PentahoReport\Bundle\Service;

use Optime\PentahoReport\Lib\ReportBI;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class ReportService
{

    /**
     * @var ParameterBag
     */
    private $bag;

    /**
     * ReportService constructor.
     */
    public function __construct(ContainerBagInterface $bag)
    {
        $this->bag = $bag;
    }

    public function downloadReport($report, $subfolder, $reportParams)
    {
        $urlAuth = $this->bag->get('pentaho.url_auth');
        $baseURI = $this->bag->get('pentaho.base_uri');
        $biUser = $this->bag->get('pentaho.bi_user');
        $biPass = $this->bag->get('pentaho.bi_pass');

        $report = (is_null($report)) ? '' : $report;
        $subfolder = (is_null($subfolder)) ? '' : $subfolder;

        $reportBI = new ReportBI($urlAuth, $baseURI, $biUser, $biPass);

        $reportBI->getBIServerReport($report, $subfolder, $reportParams);

        return true;
    }
}