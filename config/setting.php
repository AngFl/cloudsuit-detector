<?php
/**
 *
 */

return [
     'database' => [
         'type'         => 'mysql',
         'host'         => '{{conf.service.tcbdb.host}}',
         'port'         =>  {{conf.service.tcbdb.port}},
         'username'     =>  '{{conf.service.tcbdb.user}}',
         'password'     =>  '{{conf.service.tcbdb.pass}}',
     ],

     'redis'  =>  [
         'host'         =>  '{{conf.service.tcbredis.host}}',
         'port'         =>   {{conf.service.tcbredis.port}},
         'auth'         =>  '{{conf.service.tcbredis.pass}}',
     ],

     'elastic' => [
         'host'         => '{{conf.service.tcbes.host}}',
         'port'         =>  {{conf.service.tcbes.port}},
         'scheme'       => 'http',
         'user'         => '{{conf.service.tcbes.admin_user}}',
         'pass'         => '{{conf.service.tcbes.admin_pass}}'
      ],

      'etcd'  => [
          'endpoint'        => 'http://{{conf.service.tcbetcd.host}}:{{conf.service.tcbetcd.port}}',
      ],

      'kafka' => [
          'host'       => '{{conf.service.tcbkafka.host}}',
          'port'       =>  {{conf.service.tcbkafka.port}}
      ],

      'mongo' => [
          'host'       =>  '{{conf.service.tcbmongo.host}}',
          'port'       =>  {{conf.service.tcbmongo.port}},
          'user'       =>  '{{conf.service.tcbmongo.user}}',
          'pass'       =>  '{{conf.service.tcbmongo.pass}}',
      ],

      's3'  =>  [
          'access-key' => '{{conf.service.tcbcsp.access_key}}',
          'secret-key' => '{{conf.service.tcbcsp.secret_key}}',
          'endpoint'   =>  'http://{{conf.service.tcbcsp.ipv4}}:{{conf.service.tcbcsp.port}}'
      ],

      'cam' => [
          'secret-id'  => '{{conf.service.secret.secret_id}}',
          'secret-key' => '{{conf.service.secret.secret_key}}',
          'endpoint'   => 'http://cam.{{conf.service.cloudapi2.host}}',
      ]
];