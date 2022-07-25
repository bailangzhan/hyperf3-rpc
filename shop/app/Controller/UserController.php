<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class UserController
 * @package App\Controller
 */
#[AutoController]
class UserController
{
    /**
     * @var UserService
     */
    #[Inject]
    private $userService;

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->userService->getInfo();
    }
}