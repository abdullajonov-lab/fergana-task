<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;


/**
 * Yes you're right I could write such login on the controller itself too, but since it is kinda technical task I need to use Service just to show that I know what the hell the service layer is xD
 * BUT
 * AKCHUALLY (actually but in the meme way)
 * because of some dude made it best practice we gotta make service to write business logic
 *
 *
 * aa btw I could write Interface, abstract and some sort of things, but I'm too lazy to do that since it is just a technical task, but in prod I prefer to write it
 */
class UserService
{
    public function login($params): string|false
    {
        return JWTAuth::attempt($params);
    }

    public function register($params): bool
    {
        try {
            User::create($params);
            return true;
        } catch (Exception $e){
            return false;
        }
    }
}
