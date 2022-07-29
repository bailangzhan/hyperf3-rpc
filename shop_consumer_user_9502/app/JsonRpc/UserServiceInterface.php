<?php

namespace App\JsonRpc;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param int $gender
     */
    public function createUser(string $name, int $gender);

    /**
     * @param int $id
     */
    public function getUserInfo(int $id);

    /**
     * @return mixed
     */
    public function test();

    /**
     * @return mixed
     */
    public function getServerInfo();
}