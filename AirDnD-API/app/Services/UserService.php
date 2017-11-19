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
    public function __construct(UserRepository $repo)
    {
        parent::__construct($repo);
    }


    public function signUpUser($userName, $email, $password, $displayName)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = $this->getRepo()->signUpNewUser($userName, strtolower($email), $password, $displayName);
        $user = $this->getRepo()->get($user->pk);
        //TODO: send user signup mail soon
        return $user;
    }

}