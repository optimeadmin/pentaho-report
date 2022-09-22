<?php
/**
 * Created by PhpStorm.
 * User: MVALLARINO
 * Date: 08-May-19
 * Time: 04:13 PM
 */

namespace Optime\PentahoReport\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;

class ReportBI
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var CookieJar
     */
    private $cookieJar;

    private $urlAuth;

    private $baseURI;

    private $biUser;

    private $biPass;

    /**
     * ReportBI constructor.
     */
    public function __construct($urlAuth, $baseURI, $biUser, $biPass)
    {

        $this->urlAuth = $urlAuth;
        $this->baseURI = $baseURI;
        $this->biUser = $biUser;
        $this->biPass = $biPass;
    }


    /**
     * @param $auth
     * @param $urlWS
     * @param $reportParams
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setBIServerConnection()
    {
        // Creacion el Cliente sin SSL certificate verification
        $this->client = new Client(array('verify' => false,'http_errors'=>false));
        // Creacion del contenedor de Cookie de Sesion
        $this->cookieJar = new CookieJar();
        // Autenticacion mediante POST guardando la Cookie de sesion en $cookieJar

        $response = $this->client->request(
            'POST',
            $this->urlAuth,
            [
                'auth' => [$this->biUser, $this->biPass],
                'cookies' => $this->cookieJar,
            ]
        );

        return true;

    }

    public function getBIServerReport(string $report, string $subFolder='', string $reportParams='')
    {
        // Request del report mediante GET pasando los parametros necesarios y la Cookie de sesion
        ini_set("default_socket_timeout", 360);
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        //var_dump($reportParams);die;

        try {
            $this->setBIServerConnection();

            $name = $subFolder . $report . '.prpt/report';
            $urlWS = $this->baseURI . $name;

            $response = $this->client->request(
                'GET',
                $urlWS,
                array(
                    'cookies' => $this->cookieJar,
                    'query' => $reportParams,
                    'future' => true,
                    'stream' => true,
                )
            );


            // Obtencion de los Headers a utilizar posteriormente
            $responseHeaders = $response->getHeaders();

            //var_dump($responseHeaders);die;

            // Obtencion del filename
            $responseContentDisposition = explode(';', $responseHeaders['content-disposition'][0]);
            $filename = $responseContentDisposition[1]; // content-disposition: inline; filename*=UTF-8''behavior-report-5.xlsx

            $result = [
                'contentType' => $responseHeaders['Content-Type'][0],
                'fileName' => $filename,
                'bodyContent' => $response->getBody()->getContents(),
            ];

            $filename = substr($result["fileName"], 18);

            $fp = fopen(sys_get_temp_dir().'/'.$filename, 'w');

            // DIRECTLY DOWNLOAD
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment;' . $result['fileName'] . '');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . strlen($result['bodyContent']));
            header('Content-Type:' . $result['contentType'] . '');

            ob_clean();
            flush();
            echo $result['bodyContent'];
            flush();
            fclose($fp);
        }catch (GuzzleException $e) {
            echo 'Uh oh! ' . $e->getMessage();
        }
    }
}
