<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Http\Resources\TaskShowResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    public function index()
    {

        return TaskIndexResource::collection(
            Task::all()
        );

    }

    public function show($id)
    {

        $task = Task::query()->with('subTask')->findOrFail($id);
        $user = JWTAuth::user();
        $userModel = User::query()->with('taskTrackings.tasks')->findOrFail($user->id);

        return [
            "data" => $task,
            "user" => $user,
            "userModel" => $userModel
        ];
//        return new TaskShowResource(Task::findOrFail($id)->with('subTask'));

    }
}
