<?php

namespace App\JsonRpc;

use App\Model\User;
use App\Tools\Result;
use Hyperf\RpcServer\Annotation\RpcService;

#[RpcService(name: "UserService", protocol: "jsonrpc-http", server: "jsonrpc-http")]
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
}