<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;
use Kafka\Broker;

class KafkaDetector implements CloudSuitServiceDetector
{
    private ConnectionConfigProvider $connectionConfigProvider;
    /**
     * DatabaseDetector constructor.
     * @param ConnectionConfigProvider $connectionConfigProvider
     */
    public function __construct(ConnectionConfigProvider $connectionConfigProvider)
    {
        $this->connectionConfigProvider = $connectionConfigProvider;
    }

    public function getSuitName(): string
    {
        return 'kafka';
    }

    public function connectionReady(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $broker = Broker::getInstance();
        $socketSync = $broker->getSocket($config['host'], $config['port'], true);
        $detectResult = new DetectResult();
        try {
            $socketSync->connect();
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (\Kafka\Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function createDatabase(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function dropDatabase(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function createTable(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function dropTable(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function selectTableData(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function insertTableData(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function deleteTableData(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function createIndex(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function indexDocument(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function deleteDocument(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function insertDocument(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function queryDocument(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function deleteDocuments(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function putBucket(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function putObject(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function deleteObject(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function deleteBucket(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function setValue(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function getValue(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function createTopic(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $broker = Broker::getInstance();
        $socketSync = $broker->getSocket($config['host'], $config['port'], true);
        $detectResult = new DetectResult();
        try {
            $socketSync->connect();
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (\Kafka\Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function putData(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function getData(): DetectResult
    {
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }
}