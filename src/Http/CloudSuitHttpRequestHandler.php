<?php
/**
 *
 */

namespace App\Http;


use App\CloudSuitBootstrapDetector;
use App\Config\ConnectionConfig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CloudSuitHttpRequestHandler
{
    private ConnectionConfig $connectionConfig;

    private CloudSuitBootstrapDetector $cloudSuitBootstrapDetector;

    /**
     * CloudSuitHttpRequestHandler constructor.
     * @param ConnectionConfig $connectionConfig
     * @param CloudSuitBootstrapDetector $cloudSuitBootstrapDetector
     */
    public function __construct(ConnectionConfig $connectionConfig, CloudSuitBootstrapDetector $cloudSuitBootstrapDetector)
    {
        $this->connectionConfig = $connectionConfig;
        $this->cloudSuitBootstrapDetector = $cloudSuitBootstrapDetector;
    }


    public function suitState(ServerRequestInterface $request) : ResponseInterface
    {
        dump($request->getHeaders());
    }
}