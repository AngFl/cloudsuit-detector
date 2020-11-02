<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\ElasticsearchException;

class ElasticDetector implements CloudSuitServiceDetector
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
        return 'ces';
    }

    public function connectionReady(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();
        $hosts = [
            $connectionConfig
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        $detectResult = new DetectResult();
        try {
            $result = $client->ping();
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (ElasticsearchException $exception) {
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
        $connectionConfig = $this->connectionConfigProvider->provide();
        $hosts = [
            $connectionConfig
        ];
        $params = [
            'index' => 'cloud_base_index_' . uniqid(),
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();

        $detectResult = new DetectResult();
        try {
            $result = $client->indices()->create($params);
        } catch (ElasticsearchException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }

        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function indexDocument(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();
        $hosts = [
            $connectionConfig
        ];
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [ 'testField' => 'abc']
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        $detectResult = new DetectResult();
        try {
            $result = $client->index($params);
            $detectResult->setCode(1);
            $detectResult->setMessage("ok");
            return $detectResult;
        } catch (ElasticsearchException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function deleteDocument(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();
        $hosts = [
            $connectionConfig
        ];
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        $detectResult = new DetectResult();
        try {
            $result = $client->delete($params);
        } catch (ElasticsearchException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }

        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
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