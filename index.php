<?php
/**
 *
 */
require_once __DIR__ . '/vendor/autoload.php';

use App\BootstrapDetector;
use App\Config\ConnectionConfig;
use League\CLImate\CLImate;

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new RuntimeException($message);
});

$settings = require_once __DIR__ . '/config/setting.php';
$connectionConfig = new ConnectionConfig($settings);

$bootstrapDetector = new BootstrapDetector();
$tableLineData = $bootstrapDetector->boot($connectionConfig);

// dump($tableLineData);
echo json_encode($tableLineData). PHP_EOL;

// $cliTerminal = new CLImate();
// $cliTerminal->table($tableLineData);