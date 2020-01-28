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
        $trackings = TaskTracking::query()->where('user_id', '=', $user->id)->with('tasks')->get();

        return [
            "data" => $trackings
        ];

    }

    public function show($id)
    {

        $user = JWTAuth::user();
        $tracking = TaskTracking::query()->where('user_id', '=', $user->id)->with('tasks')->findOrFail($id);

        return [
            "data" => $tracking
        ];

    }

}