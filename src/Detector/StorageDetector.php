<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;
use Aws\Credentials\Credentials;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class StorageDetector implements CloudSuitServiceDetector
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
        return 'csp';
    }

    public function connectionReady(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $s3Client = new S3Client([
            'region'       => 'chengdu',
            'version'      => 'latest',
            'endpoint'     => $config['endpoint'],
            'credentials' => [
                'key'     => $config['access-key'],
                'secret'  => $config['secret-key'],
            ]
        ]);
        $detectResult = new DetectResult();
        try {
            $buckets = $s3Client->listBuckets();
            $detectResult->setCode(1);
            $detectResult->setMessage('ok');
            return $detectResult;
        } catch (S3Exception $exception) {
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
        $config = $this->connectionConfigProvider->provide();
        $s3Client = new S3Client([
            'region'       => 'chengdu',
            'version'      => 'latest',
            'endpoint'     => $config['endpoint'],
            'credentials' => [
                'key'     => $config['access-key'],
                'secret'  => $config['secret-key'],
            ]
        ]);
        $detectResult = new DetectResult();
        try {
            $buckets = $s3Client->createBucket(['Bucket' => 'detector-bucket']);
            $detectResult->setCode(1);
            $detectResult->setMessage('ok');
            return $detectResult;
        } catch (S3Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function putObject(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        $s3Client = new S3Client([
            'region'       => 'chengdu',
            'version'      => 'latest',
            'endpoint'     => $config['endpoint'],
            'credentials' => [
                'key'     => $config['access-key'],
                'secret'  => $config['secret-key'],
            ]
        ]);
        $detectResult = new DetectResult();
        try {
            $buckets = $s3Client->listBuckets();
            $detectResult->setCode(1);
            $detectResult->setMessage('ok');
            return $detectResult;
        } catch (S3Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function deleteObject(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        // $credentials = new Credentials();
        $s3Client = new S3Client([
            'region'       => 'chengdu',
            'version'      => 'latest',
            'endpoint'     => $config['endpoint'],
            'credentials' => [
                'key'     => $config['access-key'],
                'secret'  => $config['secret-key'],
            ]
        ]);
        $detectResult = new DetectResult();
        try {
            $buckets = $s3Client->listBuckets();
            $detectResult->setCode(1);
            $detectResult->setMessage('ok');
            return $detectResult;
        } catch (S3Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
    }

    public function deleteBucket(): DetectResult
    {
        $config = $this->connectionConfigProvider->provide();
        // $credentials = new Credentials();
        $s3Client = new S3Client([
            'region'       => 'chengdu',
            'version'      => 'latest',
            'endpoint'     => $config['endpoint'],
            'credentials' => [
                'key'     => $config['access-key'],
                'secret'  => $config['secret-key'],
            ]
        ]);
        $detectResult = new DetectResult();
        try {
            $buckets = $s3Client->deleteBucket(['Bucket' => 'detector-bucket']);
            $detectResult->setCode(1);
            $detectResult->setMessage('ok');
            return $detectResult;
        } catch (S3Exception $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
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