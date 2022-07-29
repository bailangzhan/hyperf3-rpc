<?php

namespace App\JsonRpc;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param int $gender
     * @return array
     */
    public function createUser(string $name, int $gender): array;

    /**
     * @param int $id
     * @return array
     */
    public function getUserInfo(int $id): array;

    /**
     * @return array
     */
    public function test(): array;

    public function discovery(): array;

    public function getServerInfo(): array;

    public function getNacosConfig(): array;

}