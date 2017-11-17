<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 7:28 PM
 */

namespace App\Services;

use App\Models\UserModel;
use App\Repositories\UserRepository;

class UserService extends AbstractService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }


    public function signUpUser($userName, $email, $password, $displayName)
    {

        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = $this->userRepository->signUpNewUser($userName, strtolower($email), $password, $displayName);

        $user = $this->userRepository->get($user->pk);

        //send user signup mail soon

        return $user;
    }

}