<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        return [
            "data" => User::query()->get(),
        ];

    }
}
