<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        return [
            "data" => User::query()->get(),
        ];

    }

    public function store(Request $request)
    {
        $user = new User();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->name = $request->input('name');

        $user->save();

        if($user->id === 1){
            $user->isAdmin = true;
            $user->save();
        }

        return [
            "success" => true
        ];

    }
}
