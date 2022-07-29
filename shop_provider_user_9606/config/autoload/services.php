<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'enable' => [
        'discovery' => false,
        'register' => false,
    ],
    'consumers' => [],
    'providers' => [],
    'drivers' => [
//        'consul' => [
//            'uri' => 'http://192.168.72.60:8500',
//            'token' => '',
//            'check' => [
//                'deregister_critical_service_after' => '90m',
//                'interval' => '1s',
//            ],
//        ],
        'nacos' => [
            // nacos server url like https://nacos.hyperf.io, Priority is higher than host:port
            // 'url' => '',
            // The nacos host info
            'host' => '192.168.72.60',
            'port' => 8848,
            // The nacos account info
            'username' => 'nacos',
            'password' => 'nacos',
            'guzzle' => [
                'config' => null,
            ],
            'group_name' => 'api',
            'namespace_id' => 'hyperf',
            'heartbeat' => 5,
            'ephemeral' => true,
        ],
    ],
];
