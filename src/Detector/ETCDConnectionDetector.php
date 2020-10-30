<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;

class ETCDConnectionDetector implements CloudSuitServiceDetector
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
        return 'etcd';
    }

    public function connectionReady(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();

        $opts = [
            'http' => [
                'method'   =>"GET",
                'timeout'  => 5,
                'header'  =>"Accept-language: en\r\nCookie: foo=bar\r\n"
            ]
        ];

        $context = stream_context_create($opts);
        $detectResult = new DetectResult();
        try {
            /* Sends an http request to www.example.com
               with additional headers shown above */
            $response = file_get_contents($connectionConfig['endpoint'] . '/version', false, $context);
            $detectResult->setCode(1);
            $detectResult->setMessage($response);
            return $detectResult;
        } catch (\RuntimeException $exception) {
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
        $detectResult = new DetectResult();
        $detectResult->setCode(-1);
        $detectResult->setMessage("not supported");
        return $detectResult;
    }

    public function putData(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();

        $opts = [
            'http' => [
                'method'   =>"POST",
                'timeout'  => 5,
                'header'   => "Content-Type:application/json",

                'content'  => json_encode(['key' => 'Zm9v', 'value' => 'YmFy'])
            ]
        ];

        $context = stream_context_create($opts);
        $detectResult = new DetectResult();
        try {
            $response = file_get_contents($connectionConfig['endpoint'] . '/v3/kv/put', false, $context);
            $detectResult->setCode(1);
            $detectResult->setMessage($response);
            return $detectResult;
        } catch (\RuntimeException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function getData(): DetectResult
    {
        $connectionConfig = $this->connectionConfigProvider->provide();

        $opts = [
            'http' => [
                'method'   => "POST",
                'timeout'  => 5,
                'header'   => "Content-Type:application/json",

                'content'  => json_encode(['key' => 'Zm9v'])
            ]
        ];

        $context = stream_context_create($opts);
        $detectResult = new DetectResult();
        try {
            $response = file_get_contents($connectionConfig['endpoint'] . '/v3/kv/range', false, $context);
            $detectResult->setCode(1);
            $detectResult->setMessage($response);
            return $detectResult;
        } catch (\RuntimeException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }
}