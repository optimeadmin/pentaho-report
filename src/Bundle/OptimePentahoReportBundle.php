<?php

namespace Optime\PentahoReport\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OptimePentahoReportBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {

    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}