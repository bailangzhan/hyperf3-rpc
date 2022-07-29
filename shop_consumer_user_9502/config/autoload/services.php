<?php
// 服务定义
$consumerServices = [
    'UserService' => \App\JsonRpc\UserServiceInterface::class,
];
return [
    'consumers' => value(function () use ($consumerServices) {
        $consumers = [];
        foreach ($consumerServices as $name => $interface) {
            $consumers[] = [
                'name' => $name,
                'service' => $interface,
                // 负载均衡算法，可选，默认值为 random
                'load_balancer' => 'round-robin',
                // 这个消费者要从哪个服务中心获取节点信息，如不配置则不会从服务中心获取节点信息
                'registry' => [
                    'protocol' => 'nacos',
                    'address' => 'http://192.168.72.60:8848',
                ],
                // nodes配置可以不注册，为了确认是从nacos获取的节点信息，这里先屏蔽
                // 'nodes' => [
                //    ['host' => '127.0.0.1', 'port' => 9600],
                //],
            ];
        }
        return $consumers;
    }),
    // 服务驱动，配置 nacos
    'drivers' => [
        'nacos' => [
            // nacos server url like https://nacos.hyperf.io, Priority is higher than host:port
            // 'url' => '',
            // The nacos host info
            'host' => '192.168.72.60',
            'port' => 8848,
            // The nacos account info
            'username' => null,
            'password' => null,
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