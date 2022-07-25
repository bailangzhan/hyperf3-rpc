<?php

namespace App\JsonRpc;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param int $gender
     * @return string
     */
    public function createUser(string $name, int $gender): string;

    /**
     * @param int $id
     * @return array
     */
    public function getUserInfo(int $id): array;
}