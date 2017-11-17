<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 6:24 PM
 */

namespace App\Http\Controllers\v1;


use App\Services\UserService;
use Illuminate\Http\Request;

class UserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function addUser(Request $request)
    {
        $data = $request->all();
        //$header = $request->header();

        $this->userService->addUder($data);
    }

}