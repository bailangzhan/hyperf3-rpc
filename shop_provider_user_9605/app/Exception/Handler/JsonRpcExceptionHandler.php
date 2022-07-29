<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class JsonRpcExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $responseContents = $response->getBody()->getContents();
        $responseContents = json_decode($responseContents, true);
        if (!empty($responseContents['error'])) {
            $port = null;
            $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
            $servers = $config->get('server.servers');
            foreach ($servers as $k => $server) {
                if ($server['name'] == 'jsonrpc-http') {
                    $port = $server['port'];
                    break;
                }
            }
            $responseContents['error']['message'] .= " - {$config->get('app_name')}:{$port}";
        }
        $data = json_encode($responseContents, JSON_UNESCAPED_UNICODE);
        return $response->withStatus(200)->withBody(new SwooleStream($data));
    }
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
