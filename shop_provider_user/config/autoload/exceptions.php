<?php

declare(strict_types=1);

return [
    'handler' => [
//        'http' => [
//            Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class,
//            App\Exception\Handler\AppExceptionHandler::class,
//        ],
        'jsonrpc-http' => [
            App\Exception\Handler\JsonRpcExceptionHandler::class,
        ],
    ],
];
