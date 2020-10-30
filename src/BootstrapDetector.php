<?php
/**
 *
 */

namespace App;


use App\Config\ConnectionConfig;
use App\Detector\CloudSuitServiceDetector;
use App\Detector\DatabaseDetector;
use App\Detector\ElasticDetector;
use App\Detector\ETCDConnectionDetector;
use App\Detector\KafkaDetector;
use App\Detector\MongoDetector;
use App\Detector\RedisDetector;
use App\Detector\StorageDetector;
use App\Provider\AwsConnectionConfigProvider;
use App\Provider\ConnectionConfigProvider;
use App\Provider\DatabaseConnectionConfigProvider;
use App\Provider\ElasticConnectionConfigProvider;
use App\Provider\ETCDConnectionConfigProvider;
use App\Provider\KafkaConnectionConfigProvider;
use App\Provider\MongoConnectionConfigProvider;
use App\Provider\RedisConnectionConfigProvider;

class BootstrapDetector
{
    private array $detectorClasses = [
        DatabaseDetector::class,
        ElasticDetector::class,
        ETCDConnectionDetector::class,
        KafkaDetector::class,
        MongoDetector::class,
        RedisDetector::class,
        StorageDetector::class
    ];

    private array $connectionConfigProviders = [
        AwsConnectionConfigProvider::class,
        DatabaseConnectionConfigProvider::class,
        ElasticConnectionConfigProvider::class,
        ETCDConnectionConfigProvider::class,
        KafkaConnectionConfigProvider::class,
        MongoConnectionConfigProvider::class,
        RedisConnectionConfigProvider::class
    ];

    private array $detectState = [
        'service'                     => '',
        'connection-status'           => 'yes',
        'tdsql-create-database'     => 'yes',
        'tdsql-create-table'        => 'yes',
        'tdsql-insert-data'         => 'yes',
        'tdsql-select-data'         => 'yes',
        'tdsql-delete-data'         => 'yes',
        'tdsql-drop-table'          => 'yes',
        'tdsql-drop-database'       => 'yes',
        'es-create-index'      => 'yes',
        'es-index-document'      => 'yes',
        'es-delete-document' => 'yes',
        'mongo-insert-document' => 'yes',
        'mongo-query-document'  => 'yes',
        'mongo-delete-document' => 'yes',
        'csp-put-bucket'        => 'yes',
        'csp-put-object'        => 'yes',
        'csp-delete-object'     => 'yes',
        'csp-delete-bucket'     => 'yes',
        'redis-set-value'       => 'yes',
        'redis-get-value'       => 'yes',
        'kafka-create-topic'    => 'yes',
        'kafka-produce-msg'     => 'yes',
        'kafka-consume-msg'     => 'yes',
        'kafka-delete-topic'    => 'yes',
        'etcd-put-data'         => 'yes',
        'etcd-get-data'         => 'yes',
    ];

    public function boot(ConnectionConfig $connectionConfig) : array
    {
        $detectors = [];
        foreach ($this->connectionConfigProviders as $connectionConfigProvider) {
            $provider = new $connectionConfigProvider($connectionConfig);
            if ($provider instanceof ConnectionConfigProvider) {
                foreach ($this->detectorClasses as $detectorClass) {
                    if ($provider->supported($detectorClass)) {
                        $detector = new $detectorClass($provider);
                        array_push($detectors, $detector);
                    }
                }
            }
        }

        $tableLineData = [];
        if (!empty($detectors)) {
            /** @var CloudSuitServiceDetector $detector */
            foreach ($detectors as $detector) {
                $databaseState = $this->getDatabaseState($detector);
                $elasticState = $this->getElasticState($detector);
                $mongoState = $this->getMongoState($detector);
                $cspState = $this->getCspState($detector);
                $redisState = $this->getRedisState($detector);
                $kafkaState = $this->getKafkaState($detector);
                $ETCDState = $this->getETCDState($detector);
                $tableLineData[$detector->getSuitName()] =
                    array_merge(
                        ['connection-state' => $this->getConnectionState($detector)] ,
                        $databaseState, $elasticState, $mongoState, $cspState, $redisState, $kafkaState, $ETCDState);
            }

        }
        return $tableLineData;
    }

    private function getDatabaseState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $createDataBaseState = $detector->createDatabase();
        if ($createDataBaseState->getCode() < 0) {
            $detectState['tdsql-create-database'] = 'not supported';
        }

        if ($createDataBaseState->getCode() > 0) {
            $detectState['tdsql-create-database'] = 'yes';
        }
        if ($createDataBaseState->getCode() === 0) {
            $detectState['tdsql-create-database'] = 'no';
        }

        $createTableState = $detector->createTable();
        if ($createTableState->getCode() < 0) {
            $detectState['tdsql-create-table'] = 'not supported';
        }

        if ($createTableState->getCode() > 0) {
            $detectState['tdsql-create-table'] = 'yes';
        }

        if ($createTableState->getCode() === 0) {
            $detectState['tdsql-create-table'] = 'no';
        }

        $insertTableState = $detector->insertTableData();
        if ($insertTableState->getCode() < 0) {
            $detectState['tdsql-insert-data'] = 'not supported';
        }

        if ($insertTableState->getCode() > 0) {
            $detectState['tdsql-insert-data'] = 'yes';
        }

        if ($insertTableState->getCode() === 0) {
            $detectState['tdsql-insert-data'] = 'no';
        }

        $selectTableState = $detector->selectTableData();
        if ($selectTableState->getCode() < 0) {
            $detectState['tdsql-select-data'] = 'not supported';
        }

        if ($selectTableState->getCode() > 0) {
            $detectState['tdsql-select-data'] = 'yes';
        }

        if ($selectTableState->getCode() === 0) {
            $detectState['tdsql-select-data'] = 'no';
        }

        $deleteTableState = $detector->deleteTableData();
        if ($deleteTableState->getCode() < 0) {
            $detectState['tdsql-delete-data'] = 'not supported';
        }

        if ($deleteTableState->getCode() > 0) {
            $detectState['tdsql-delete-data'] = 'yes';
        }

        if ($deleteTableState->getCode() === 0) {
            $detectState['tdsql-delete-data'] = 'no';
        }

        $dropTableState = $detector->dropTable();
        if ($dropTableState->getCode() < 0) {
            $detectState['tdsql-drop-table'] = 'not supported';
        }
        if ($dropTableState->getCode() > 0) {
            $detectState['tdsql-drop-table'] = 'yes';
        }
        if ($dropTableState->getCode() === 0) {
            $detectState['tdsql-drop-table'] = 'no';
        }

        $dropDataBaseState = $detector->dropDatabase();
        if ($dropDataBaseState->getCode() < 0) {
            $detectState['tdsql-drop-database'] = 'not supported';
        }
        if ($dropDataBaseState->getCode() > 0) {
            $detectState['tdsql-drop-database'] = 'yes';
        }
        if ($dropDataBaseState->getCode() === 0) {
            $detectState['tdsql-drop-database'] = 'no';
        }
        return $detectState;
    }

    private function getElasticState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $createIndexState = $detector->createIndex();
        if ($createIndexState->getCode() < 0) {
            $detectState['es-create-index'] = 'not supported';
        }
        if ($createIndexState->getCode() > 0) {
            $detectState['es-create-index'] = 'yes';
        }
        if ($createIndexState->getCode() === 0) {
            $detectState['es-create-index'] = 'no';
        }

        $indexDocument = $detector->indexDocument();
        if ($indexDocument->getCode() < 0) {
            $detectState['es-index-document'] = 'not supported';
        }
        if ($indexDocument->getCode() > 0) {
            $detectState['es-index-document'] = 'yes';
        }
        if ($indexDocument->getCode() === 0) {
            $detectState['es-index-document'] = 'no';
        }

        $deleteDocument = $detector->deleteDocument();
        if ($deleteDocument->getCode() < 0) {
            $detectState['es-delete-document'] = 'not supported';
        }

        if ($deleteDocument->getCode() > 0) {
            $detectState['es-delete-document'] = 'yes';
        }
        if ($deleteDocument->getCode() === 0) {
            $detectState['es-delete-document'] = 'no';
        }

        return $detectState;
    }

    private function getMongoState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $insertDocument = $detector->insertDocument();
        if ($insertDocument->getCode() < 0) {
            $detectState['mongo-insert-document'] = 'not supported';
        }

        if ($insertDocument->getCode() > 0) {
            $detectState['mongo-insert-document'] = 'yes';
        }

        if ($insertDocument->getCode() === 0) {
            $detectState['mongo-insert-document'] = 'no';
        }

        $queryDocument = $detector->queryDocument();
        if ($queryDocument->getCode() < 0) {
            $detectState['mongo-query-document'] = 'not supported';
        }

        if ($queryDocument->getCode() > 0) {
            $detectState['mongo-query-document'] = 'yes';
        }

        if ($queryDocument->getCode() === 0) {
            $detectState['mongo-query-document'] = 'no';
        }

        $deleteDocument = $detector->deleteDocument();
        if ($deleteDocument->getCode() < 0) {
            $detectState['mongo-delete-document'] = 'not supported';
        }

        if ($deleteDocument->getCode() > 0) {
            $detectState['mongo-delete-document'] = 'yes';
        }
        if ($deleteDocument->getCode() === 0) {
            $detectState['mongo-delete-document'] = 'no';
        }
        return $detectState;
    }

    private function getCspState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $putBucket = $detector->putBucket();
        if ($putBucket->getCode() < 0) {
            $detectState['csp-put-bucket'] = 'not supported';
        }

        if ($putBucket->getCode() > 0) {
            $detectState['csp-put-bucket'] = 'yes';
        }

        if ($putBucket->getCode() === 0) {
            $detectState['csp-put-bucket'] = 'no';
        }

        $putObject = $detector->putObject();
        if ($putObject->getCode() < 0) {
            $detectState['csp-put-object'] = 'not supported';
        }

        if ($putObject->getCode() > 0) {
            $detectState['csp-put-object'] = 'yes';
        }

        if ($putObject === 0) {
            $detectState['csp-put-object'] = 'no';
        }

        $deleteObject = $detector->deleteObject();
        if ($deleteObject->getCode() < 0) {
            $detectState['csp-delete-object'] = 'not supported';
        }

        if ($deleteObject->getCode() > 0) {
            $detectState['csp-delete-object'] = 'yes';
        }

        if ($deleteObject->getCode() === 0) {
            $detectState['csp-delete-object'] = 'no';
        }

        $deleteBucket = $detector->deleteBucket();
        if ($deleteBucket->getCode() < 0) {
            $detectState['csp-delete-bucket'] = 'not supported';
        }

        if ($deleteBucket->getCode() > 0) {
            $detectState['csp-delete-bucket'] = 'yes';
        }

        if ($deleteBucket === 0) {
            $detectState['csp-delete-bucket'] = 'no';
        }
        return $detectState;
    }

    private function getRedisState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $setValue = $detector->setValue();
        if ($setValue->getCode() < 0) {
            $detectState['redis-set-value'] = 'not supported';
        }

        if ($setValue->getCode() > 0) {
            $detectState['redis-set-value'] = 'yes';
        }

        if ($setValue->getCode() === 0) {
            $detectState['redis-set-value'] = 'no';
        }

        $getValue = $detector->getValue();
        if ($getValue->getCode() < 0) {
            $detectState['redis-get-value'] = 'not supported';
        }

        if ($getValue->getCode() > 0) {
            $detectState['redis-get-value'] = 'yes';
        }

        if ($getValue->getCode() === 0) {
            $detectState['redis-get-value'] = 'no';
        }
        return $detectState;
    }

    private function getKafkaState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $createTopic = $detector->createTopic();
        if ($createTopic->getCode() < 0) {
            $detectState['kafka-create-topic'] = 'not supported';
        }

        if ($createTopic->getCode() > 0) {
            $detectState['kafka-create-topic'] = 'yes';
        }

        if ($createTopic->getCode() === 0) {
            $detectState['kafka-create-topic'] = 'no';
        }

        $createTopic = $detector->createTopic();
        if ($createTopic->getCode() < 0) {
            $detectState['kafka-produce-msg'] = 'not supported';
        }

        if ($createTopic->getCode() > 0) {
            $detectState['kafka-produce-msg'] = 'yes';
        }

        if ($createTopic->getCode() === 0) {
            $detectState['kafka-produce-msg'] = 'no';
        }

        $createTopic = $detector->createTopic();
        if ($createTopic->getCode() < 0) {
            $detectState['kafka-consume-msg'] = 'not supported';
        }

        if ($createTopic->getCode() > 0) {
            $detectState['kafka-consume-msg'] = 'yes';
        }

        if ($createTopic->getCode() === 0) {
            $detectState['kafka-consume-msg'] = 'no';
        }

        $createTopic = $detector->createTopic();
        if ($createTopic->getCode() < 0) {
            $detectState['kafka-delete-topic'] = 'not supported';
        }

        if ($createTopic->getCode() > 0) {
            $detectState['kafka-delete-topic'] = 'yes';
        }

        if ($createTopic->getCode() === 0) {
            $detectState['kafka-delete-topic'] = 'no';
        }
        return $detectState;
    }

    private function getETCDState(CloudSuitServiceDetector $detector)
    {
        $detectState = [];
        $putData = $detector->putData();
        if ($putData->getCode() < 0) {
            $detectState['etcd-put-data'] = 'not supported';
        }

        if ($putData->getCode() > 0) {
            $detectState['etcd-put-data'] = 'yes';
        }

        if ($putData->getCode() === 0) {
            $detectState['etcd-put-data'] = 'no';
        }

        $getData = $detector->getData();
        if ($getData->getCode() < 0) {
            $detectState['etcd-put-data'] = 'not supported';
        }

        if ($getData->getCode() > 0) {
            $detectState['etcd-put-data'] = 'yes';
        }

        if ($getData->getCode() === 0) {
            $detectState['etcd-put-data'] = 'no';
        }
        return $detectState;
    }

    /**
     * @param CloudSuitServiceDetector $detector
     */
    private function getConnectionState(CloudSuitServiceDetector $detector): string
    {
        $detectResult = $detector->connectionReady();
        if ($detectResult->getCode() > 0) {
            return 'ready';
        } else {
            return 'failed;' . $detectResult->getMessage();
        }
    }
}