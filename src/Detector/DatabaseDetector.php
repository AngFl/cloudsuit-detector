<?php
/**
 *
 */

namespace App\Detector;


use App\Provider\ConnectionConfigProvider;
use PDO;

class DatabaseDetector implements CloudSuitServiceDetector
{
    private ConnectionConfigProvider $connectionConfigProvider;

    private string $databaseDsn;

    private string $username;

    private string $password;

    /**
     * DatabaseDetector constructor.
     * @param ConnectionConfigProvider $connectionConfigProvider
     */
    public function __construct(ConnectionConfigProvider $connectionConfigProvider)
    {
        $this->connectionConfigProvider = $connectionConfigProvider;
        $connectionConfig = $this->connectionConfigProvider->provide();
        $this->databaseDsn = sprintf("mysql:dbname=mysql;host=%s;port=%d", $connectionConfig['host'], $connectionConfig['port']);
        $this->username = isset($connectionConfig['username']) ? $connectionConfig['username'] : '';
        $this->password = isset($connectionConfig['password']) ? $connectionConfig['password'] : '';
    }

    public function getSuitName(): string
    {
        return 'tdsql';
    }


    public function connectionReady() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function createDatabase() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function dropDatabase() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function createTable() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql = "CREATE table `deploy_detector` (`id` INT(11) AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(250) NOT NULL);";
            $pdo->exec($sql);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function dropTable() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql = "DROP TABLE `deploy_detector`;";
            $pdo->exec($sql);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function selectTableData() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql = "SELECT * FROM `deploy_detector` LIMIT 1";
            $pdoStatement = $pdo->query($sql);
            $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function insertTableData() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql = "INSERT INTO `deploy_detector` (`name`) VALUES (:name);";
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindValue("name", "name-value", PDO::PARAM_STR);
            $pdoStatement->execute();
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
        return $detectResult;
    }

    public function deleteTableData() :DetectResult
    {
        $detectResult = new DetectResult();
        try {
            $pdo = new \PDO($this->databaseDsn, $this->username, $this->password);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql = "DELETE FROM `deploy_detector` WHERE id = :id";
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindValue("id", 1, PDO::PARAM_INT);
            $pdoStatement->execute();
        } catch (\PDOException $exception) {
            $detectResult->setCode(0);
            $detectResult->setMessage($exception->getMessage());
            return $detectResult;
        }
        $detectResult->setCode(1);
        $detectResult->setMessage("ok");
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