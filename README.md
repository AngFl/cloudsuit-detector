## TCB-TCS 底座服务检测工具

###

服务安装 

```bash
composer install 
``` 

镜像构建

```
docker build -t example.mpaas/cloudsuit-detector:tag_name .
```

服务部署

```
kubectl apply -f cloudsuit-detectorl.yaml -f cloudsuit-detector-app.yaml
```

使用

- 底座中间服务检测接口

```bash
curl -i -X GET http://<example.endpoint>/suit
```

返回结果示例：

```json
{
    "csp": {
        "connection-state": "ready",
        "csp-put-bucket": "yes",
        "csp-put-object": "yes",
        "csp-delete-object": "yes",
        "csp-delete-bucket": "yes"
    },
    "tdsql": {
        "connection-state": "ready",
        "tdsql-create-database": "yes",
        "tdsql-create-table": "yes",
        "tdsql-insert-data": "yes",
        "tdsql-select-data": "yes",
        "tdsql-delete-data": "yes",
        "tdsql-drop-table": "yes",
        "tdsql-drop-database": "yes"
    },
   ...
}
```

返回结果说明：

| 字段名称                   | 字段说明   |      值(说明)          |
| ---------------------- |---------| ----------------- |
| connection-state         | 中间件链接状态     |  ready  |
| tdsql-create-database    | TDSQL 创建数据库         | yes |
| tdsql-create-table       | TDSQL创建数据表         | yes |
| tdsql-insert-data        | TDSQL插入数据表         | yes |
| tdsql-select-data    |    TDSQL查询数据表   |  yes | 
| tdsql-delete-data    |  TDSQL 删除表数据 | yes | 
| tdsql-drop-table     |  TDSQL 删除数据表  | yes |  
| tdsql-drop-database  | TDSQL 删除数据库 | yes |
| es-create-index      | ElasticSearch 创建索引 | yes | 
| es-index-document    | ElasticSearch 索引文档 | yes | 
| es-delete-document   | ElasticSearch 删除文档 |yes|
| mongo-insert-document| Mongo插入文档对象 | yes
| mongo-query-document | Mongo查询文档对象 | yes | 
| mongo-delete-document| Mongo删除文档对象 | yes | 
| csp-put-bucket       | CSP创建桶 | yes   |
| csp-put-object       | CSP创建对象 | yes |
| csp-delete-object    | CSP删除对象 | yes |
| csp-delete-bucket    | CSP删除桶 | yes |
| redis-set-value      | Redis设置缓存值 | yes | 
| redis-get-value      | Redis获取缓存值 | yes |
| kafka-create-topic   | Kafka 创建Topic | yes |
| kafka-produce-msg    | Kafka 生产消息 | yes | 
| kafka-consume-msg    | Kafka 消费消息 | yes | 
| kafka-delete-topic    | Kafka 删除Topic | yes |  
| etcd-put-data         | ETCD set数据 | yes |
| etcd-get-data         | ETCD get数据 | yes |  