<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 7:29 PM
 */

namespace App\Repositories;

class UserRepository extends AbstractRepository
{

    public function createUser($user)
    {
        return $this->getModel()->store($user);
    }

    public function signUpNewUser($username, $email, $password, $displayName)
    {
        $user = $this->getModel();
        $user->fill(
            [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'displayname' => $displayName,
            ]);
        $user->save();
        return $user;
    }


    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\UserModel';
    }
}