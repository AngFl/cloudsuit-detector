<?php
/**
 *
 */

namespace App\Detector;


interface CloudSuitServiceDetector
{

    public function getSuitName() : string;

    /**
     * @DetectResult
     */
    public function connectionReady() :DetectResult;

    /**
     * @DetectResult
     */
    public function createDatabase(): DetectResult;

    /**
     * @DetectResult
     */
    public function dropDatabase(): DetectResult;

    public function createTable(): DetectResult;

    public function dropTable(): DetectResult;

    public function selectTableData(): DetectResult;

    public function insertTableData(): DetectResult;

    public function deleteTableData(): DetectResult ;

    public function createIndex() : DetectResult;

    public function indexDocument() : DetectResult;

    /**
     * ElasticSearch 文档删除操作
     * @DetectResult
     */
    public function deleteDocument(): DetectResult;

    public function insertDocument(): DetectResult;

    public function queryDocument() : DetectResult;

    /**
     * mongo 文档删除操作
     * @DetectResult
     */
    public function deleteDocuments() : DetectResult;

    /**
     * 存储服务操作
     * @DetectResult
     */
    public function putBucket(): DetectResult;

    public function putObject() : DetectResult;

    public function deleteObject() : DetectResult;

    public function deleteBucket(): DetectResult;

    /**
     * Redis服务操作
     * @DetectResult
     */
    public function setValue() :DetectResult ;

    public function getValue() :DetectResult;

    /**
     * kafka 服务操作
     * @DetectResult
     */
    public function createTopic() : DetectResult;

    /**
     * ETCD 服务操作
     * @DetectResult
     */
    public function putData(): DetectResult;

    public function getData(): DetectResult;
}