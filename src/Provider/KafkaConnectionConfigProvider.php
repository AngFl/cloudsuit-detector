<?php
/**
 *
 */

namespace App\Provider;


use App\Config\ConnectionConfig;
use App\Detector\KafkaDetector;

class KafkaConnectionConfigProvider implements ConnectionConfigProvider
{
    private ConnectionConfig $connectionConfig;
    /**
     * DatabaseConnectionConfigProvider constructor.
     * @param ConnectionConfig $connectionConfig
     */
    public function __construct(ConnectionConfig $connectionConfig)
    {
        $this->connectionConfig = $connectionConfig;
    }

    public function provide(): array
    {
        $config = $this->connectionConfig->getConfig();
        return $config['kafka'];
    }

    public function supported(string $className): bool
    {
        return KafkaDetector::class == $className;
    }
}