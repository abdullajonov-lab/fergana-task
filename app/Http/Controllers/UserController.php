<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected  UserService $userService)
    {
    }

    public function login(UserLoginRequest $resource)
    {
        $login = $this->userService->login($resource->validated());
        if ($login){
            return response()->json(["message"=>"Login successful", "data"=>$login]);
        }
        return response()->json(["message"=>"Login failed"], 401);
    }

    public function register(UserRegisterRequest $userRegisterRequest)
    {
        if($this->userService->register($userRegisterRequest->validated())){
            return response()->json(["message"=>"HELL YEAAH! Ur account has been created pal, welcome our system..."]);
        } else {
            return response()->json([
                "message"=>"HELL NOOOO, Some type of sh*t gone wrong while creating your account, please get some rest and drink coffee while our Elfs trying to fix this problem. Thanks, btw then try again later"
            ], 500);
        }
    }
}
