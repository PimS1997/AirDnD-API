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

    public function signUpUser(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|regex:/^[(a-zA-Z\s)(0-9\s)]+$/u|min:3',
            'email' => 'required|email|unique:rb_users',
            'password' => 'required|min:8',
            'displayname' => 'required|regex:/^[(a-zA-Z\s)(0-9\s)]+$/u|min:3',
        ], [
            'min' => 'The :attribute must at least be :min characters long.',
        ]);

        $user = $this->userService->signUpUser(
            $request->get('username'),
            $request->get('email'),
            $request->get('password'),
            $request->get('displayname')
        );

        if($user)
        {
            //alright! user has been made
            $response = ['status' => 'OK', 'message' => "User {$user->username} has successfully been created"];
        }
        else
        {
            //something went wrong
            $response = ['status' => 'FAIL', 'message' => "Something went wrong or user already exists in DB"];
        }

        return response()->json($response, 201);

/*        $data = $request->all();
        //$header = $request->header();

        $this->userService->addUder($data);*/
    }

}