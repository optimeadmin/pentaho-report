# Pentaho Report

Paquete que permite configurar facilmente la conexión hacia un servidor de PRD para descargar los reportes como si fueran locales

## Instalación
    composer require optimeconsulting/pentaho-report

## Configuración

Debemos configurar correctamente los siguientes parametros que luego serán recibidos por la clase que vamos a usar para la descarga

**PENTAHO_URL_AUTH:** url hacia donde se envia la petición de autenticación, por ejemplo `https://servidorpentaho.com/pentaho/j_spring_security_check`

**PENTAHO_BASE_URI:** url base hacia donde se haran las solicitudes de los reportes, ejemplo     `https://servidorpentaho.com/pentaho/api/repos/:home:Reports:`

**PENTAHO_BI_USER:** usuario con permisos para descargar los reportes de este servidor

**PENTAHO_BI_PASS:** contraseña del usuario en cuestión

En el caso del DNA podemos configurar esto en el config_var.php o en la tabla parameters, para algun proyecto en symfony debemos hacer en el .env

En symfony también debemos registrar el bundle en el `config/bundles.php`

```php
<?php

return [
    ...
    \Optime\PentahoReport\Bundle\OptimePentahoReportBundle::class => ['all' => true]
];
```
Además deberemos registrar las rutas del bundle en `config/routes.yaml`

```yaml
pentahoreport:
    resource: "@OptimePentahoReportBundle/Bundle/Controller"
    type: annotation
```

## Uso
Una vez que tengamos todo completamente configurado en un proyecto Stanalone solo debemos instanciar la clase ReportBI.php y pasar los 4 parametros que configuramos previamente y luego usar el método `getBIServerReport()` donde pasaremos lo siguiente:

**$report:** nombre del reporte en el servidor pentaho

**$subFolder:** nombre de la subcarpeta donde se escuentra el reporte si es que la hay

**$reportParams:** parametros extra que necesite el reporte, se espera el query string

```php
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

```
Para symfony ya tenemos un controlador que maneja todo esto y solo debemos usar la ruta definida en el para la descarga igual pasando al menos el nombre del reporte `/pentahoreport/download?report=users` o `/pentahoreport/download?report=users&subfolder=Users&year2022` si deseamos pasar el subfolder y cualquier otro parametro
