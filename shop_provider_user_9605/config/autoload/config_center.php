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
use Hyperf\ConfigCenter\Mode;

return [
    'enable' => (bool) env('CONFIG_CENTER_ENABLE', true),
    'driver' => env('CONFIG_CENTER_DRIVER', 'nacos'),
    'mode' => env('CONFIG_CENTER_MODE', Mode::PROCESS),
    'drivers' => [
        'nacos' => [
            'driver' => Hyperf\ConfigNacos\NacosDriver::class,
            'merge_mode' => Hyperf\ConfigNacos\Constants::CONFIG_MERGE_OVERWRITE,
            'interval' => 3,
            // listener_config 下可以配置多个监听对象
            // default_key 表示默认的 key
            'default_key' => 'hyperf_config',
            'listener_config' => [
                // dataId, group, tenant, type, content
                'hyperf_config' => [
                    'tenant' => 'hyperf', // 命名空间id
                    'data_id' => 'hyperf-service-config', // DataID
                    'group' => 'DEFAULT_GROUP', // 分组ID
                    'type' => 'json' // 格式，我们一般选择 json 或者 yaml
                ],
                // 这里也可以配置其他 key
                'hyperf_env' => [
                    'tenant' => 'hyperf', // 命名空间id
                    'data_id' => env('APP_NAME') . "_" . env("APP_ENV"), // DataID
                    'group' => 'DEFAULT_GROUP', // 分组ID
                    'type' => 'json' // 格式
                ],
            ],
            'client' => [
                // nacos server url like https://nacos.hyperf.io, Priority is higher than host:port
                // 'uri' => '',
                'host' => '192.168.72.60',
                'port' => 8848,
                'username' => 'nacos',
                'password' => 'nacos',
                'guzzle' => [
                    'config' => null,
                ],
            ],
        ],
    ],
];
