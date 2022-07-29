<?php

namespace App\JsonRpc;

use Hyperf\RpcClient\AbstractServiceClient;

class UserService extends AbstractServiceClient
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected string $serviceName = 'UserService';
    /**
     * 定义对应服务提供者的服务协议
     * @var string
     */
    protected string $protocol = 'jsonrpc-http';

    /**
     * @param string $name
     * @param int $gender
     * @return mixed|string
     */
    public function createUser(string $name, int $gender)
    {
        return $this->__request(__FUNCTION__, compact('name', 'gender'));
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function getUserInfo(int $id)
    {
        return 123;
        return $this->__request(__FUNCTION__, compact('id'));
    }
}