<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\TaskTracking;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskTrackingController extends Controller
{

    public function index()
    {

        $user = JWTAuth::user();
//        $userModel = User::query()->with('taskTrackings.tasks')->findOrFail($user->id);
        $trackings = TaskTracking::query()->where('user_id', '=', $user->id)->with('tasks')->get();

        return [
            "data" => $trackings
        ];

    }

}