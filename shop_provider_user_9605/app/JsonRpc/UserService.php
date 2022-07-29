<?php

namespace App\JsonRpc;

use App\Model\User;
use App\Tools\Result;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Contract\ConfigInterface;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\ServiceGovernanceConsul\ConsulAgent;
use Hyperf\Utils\ApplicationContext;
use Hyperf\ServiceGovernanceNacos\Client;
use Hyperf\Utils\Codec\Json;

#[RpcService(name: "UserService", protocol: "jsonrpc-http", server: "jsonrpc-http", publishTo: "nacos")]
class UserService implements UserServiceInterface
{
    /**
     * @param string $name
     * @param int $gender
     * @return array
     */
    public function createUser(string $name, int $gender): array
    {
        if (empty($name)) {
            throw new \RuntimeException("name不能为空");
        }
        $result = User::query()->create([
            'name' => $name,
            'gender' => $gender,
        ]);
        return $result ? Result::success() : Result::error("fail");
    }

//    /**
//     * @param int $id
//     * @return array
//     */
//    public function getUserInfo(int $id): array
//    {
//        $user = User::query()->find($id);
//        if (empty($user)) {
//            throw new \RuntimeException("user not found");
//        }
//        return [
//            'code' => 200,
//            'message' => 'success',
//            'data' => $user->toArray(),
//        ];
//    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserInfo(int $id): array
    {
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new \RuntimeException("user not found");
        }
        return Result::success($user->toArray());
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function test(): array
    {
        // 注销服务
        $agent = ApplicationContext::getContainer()->get(ConsulAgent::class);
        $agent->deregisterService('UserService-0');

        $agent = ApplicationContext::getContainer()->get(ConsulAgent::class);
        return Result::success([
            // 已注册的服务
            'services' => $agent->services()->json(),
            // 健康状态检查
            'checks' => $agent->checks()->json(),
        ]);
    }

    /**
     * 获取nacos server注册的所有服务信息
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function discovery(): array
    {
        // 获取服务名
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $groupName = $config->get('services.drivers.nacos.group_name');
        $namespaceId = $config->get('services.drivers.nacos.namespace_id');
        $client = ApplicationContext::getContainer()->get(Client::class);
        $services = Json::decode((string) $client->service->list(1, 10, $groupName, $namespaceId)->getBody());
        $details = [];
        if (!empty($services['doms'])) {
            $optional = [
                'groupName' => $groupName,
                'namespaceId' => $namespaceId,
            ];
            foreach ($services['doms'] as $service) {
                // 获取各个服务的信息
                $details[] = Json::decode((string) $client->instance->list($service, $optional)->getBody());
            }
        }
        return Result::success($details);
    }

    /**
     * 获取当前服务信息
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getServerInfo(): array
    {
        $port = null;
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $servers = $config->get('server.servers');
        $appName = $config->get('app_name');
        foreach ($servers as $k => $server) {
            if ($server['name'] == 'jsonrpc-http') {
                $port = $server['port'];
                break;
            }
        }
        return Result::success([
            'appName' => $appName,
            'port' => $port,
        ]);
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getNacosConfig(): array
    {
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        return Result::success([
            // hyperf_config 是我们在 listener_config 配置要监听的 key
            'info' => $config->get('hyperf_config'),
            'dev_info' => $config->get('hyperf_env'),
        ]);
    }

    /**
     * @param int $id
     * @return array
     */
    #[Cacheable(prefix: "userInfo", ttl: "60")]
    public function getUserInfoFromCache(int $id): array
    {
        $user = User::query()->find($id);
        if (empty($user)) {
            throw new \RuntimeException("user not found");
        }
        return Result::success($user->toArray());
    }

}