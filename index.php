<?php
/**
 *
 */
require_once __DIR__ . '/vendor/autoload.php';
$settings = require_once __DIR__ . '/config/setting.php';

use App\CloudSuitBootstrapDetector;
use App\Config\ConnectionConfig;
use App\Provider\CAMConfigProvider;
use App\Service\CloudSuitTCenterCamDetectorService;
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

$serverApplication->get('/cam', function (ServerRequestInterface $request, ResponseInterface $response, $args) use ($settings) {
    $tCenterCamDetectorService = new CloudSuitTCenterCamDetectorService(
        new CAMConfigProvider(new ConnectionConfig($settings)));
    $responseContent = $tCenterCamDetectorService->detect('DescribeRoleList');
    $messageContent = $responseContent->getMessage();
    $camApiState = $responseContent->getCode() > 0 ? 'yes' : 'no';
    $response->withHeader('Content-Type', 'application/json')
        ->getBody()
        ->write(json_encode(['cam-api-state' => $camApiState,
            'message' => str_replace('HTTP/1.1 405 Not Allowed', '', $messageContent)]));
    return $response;
});

// Run app
$serverApplication->run();