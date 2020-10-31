<?php
/**
 *
 */

return [
     'database' => [
         'type'         => 'mysql',
         'host'         => 'localhost',
         'port'         =>  3306,
         'username'     =>  'root',
         'password'     =>  'qweqwe',
     ],

     'redis'  =>  [
         'host'         =>  '127.0.0.1',
         'port'         =>   6382,
         'auth'         =>  'password',
     ],

     'elastic' => [
         'host'         => 'localhost',
         'port'         =>  9200,
         'scheme'       => 'http',
         'user'         => '',
         'pass'         => ''
      ],

      'etcd'  => [
          'endpoint'        => 'http://127.0.0.1:2379',
      ],

      'kafka' => [
          'host'       => 'localhost',
          'port'       =>  9092
      ],

      'mongo' => [
          'host'       =>  '127.0.0.1',
          'port'       =>  27017,
          'user'       =>  'cagliostro',
          'pass'       =>  'password',
      ],

      's3'  =>  [
          'access-key' => 'K2RQMKKPDTF63H8CLTCZ',
          'secret-key' => 'DFvpIEoCWLEUF8GodM8knW1NnHbAzt5qrgQwv0PD',
          'endpoint'   =>  'http://111.231.211.119'
      ],

      'cam' => [
          'secret-id'  => 'AKIDIqAE5i7C1cx4eDeuvhETfgjbOzNZXKuF',
          'secret-key' => 'AFBzraIzb2JQS5VheLp32lFYigR1PZVD',
          // 'endpoint'   => 'cam.api3.test1.tcb.fsphere.cn',
          'endpoint'   => 'localhost:8012',
      ]
];