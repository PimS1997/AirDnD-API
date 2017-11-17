<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 7:28 PM
 */

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends AbstractService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }
}