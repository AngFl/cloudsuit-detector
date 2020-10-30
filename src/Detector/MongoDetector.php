<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\ConnectionTimeoutException;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\WriteConcern;

class MongoDetector implements CloudSuitServiceDetector
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
        return 'mongo';
    }

    public function connectionReady(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $mongoDbManager = new Manager("mongodb://{$config['user']}:{$config['pass']}@{$config['host']}:{$config['port']}");
        // $mongoDbManager = new Manager("mongodb://{$config['host']}");
        $detectResult = new DetectResult();
        try {
            $session = $mongoDbManager->startSession();
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (ConnectionTimeoutException $exception) {
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
        $config = $this->connectionConfigProvider->provide();
        $mongoDbManager = new Manager("mongodb://{$config['user']}:{$config['pass']}@{$config['host']}:{$config['port']}");
        $detectResult = new DetectResult();
        try {
            $bulk = new BulkWrite(['ordered' => true]);
            $bulk->insert(['_id' => 3, 'hello' => 'world']);

            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            $result = $mongoDbManager->executeBulkWrite('db.collection', $bulk, $writeConcern);
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (ConnectionTimeoutException  | BulkWriteException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        return 1;
    }

    public function queryDocument(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $mongoDbManager = new Manager("mongodb://{$config['user']}:{$config['pass']}@{$config['host']}:{$config['port']}");
        // $mongoDbManager = new Manager("mongodb://{$config['host']}");
        $filter = ['id' => 1];
        $options = [
            'projection' => ['_id' => 0],
        ];
        $query = new Query($filter, $options);
        $detectResult = new DetectResult();
        try {
            $rows = $mongoDbManager->executeQuery('test.collection', $query);
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (Exception $e) {
            $detectResult->setCode(0);
            $detectResult->setMessage($e->getMessage());
            return $detectResult;
        }
    }

    public function deleteDocuments(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $mongoDbManager = new Manager("mongodb://{$config['user']}:{$config['pass']}@{$config['host']}:{$config['port']}");
        // $mongoDbManager = new Manager("mongodb://{$config['host']}");

        $detectResult = new DetectResult();
        try {
            $bulk = new BulkWrite(['ordered' => true]);
            $bulk->delete(['_id' => 1, 'hello' => 'world']);

            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            $result = $mongoDbManager->executeBulkWrite('db.collection', $bulk, $writeConcern);
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (ConnectionTimeoutException  | BulkWriteException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
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
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
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