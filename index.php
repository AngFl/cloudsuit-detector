<?php
/**
 *
 */
require_once __DIR__ . '/vendor/autoload.php';
$settings = require_once __DIR__ . '/config/setting.php';

use App\CloudSuitBootstrapDetector;
use App\Config\ConnectionConfig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory as ApplicationFactory;

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new RuntimeException($message);
});

$serverApplication = ApplicationFactory::create();
$serverApplication->addRoutingMiddleware();

$errorMiddleware = $serverApplication->addErrorMiddleware(true, true, true);

// Define app routes
$serverApplication->get('/suit', function (ServerRequestInterface $request, ResponseInterface $response, $args) use ($settings) {
    $cloudSuitBootstrapDetector = new CloudSuitBootstrapDetector();
    $tableLineData = $cloudSuitBootstrapDetector->boot(new ConnectionConfig($settings));
    $response->withHeader('Content-Type', 'application/json')
        ->getBody()
        ->write(json_encode($tableLineData));
    return $response;
});

// Run app
$serverApplication->run();