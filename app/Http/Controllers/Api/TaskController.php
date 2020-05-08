<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Http\Resources\TaskShowResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{


    protected $updatable = [
    ];

    public function index()
    {
        return [
            "data" => Task::query()->with('subTask')->get(),
        ];

    }

    public function show($id)
    {

        $task = Task::query()->with('subTask')->with('TaskTag')->findOrFail($id);
        $user = JWTAuth::user();
        $userModel = User::query()->with('taskTrackings.tasks')->findOrFail($user->id);

        return [
            "data" => $task,
            "user" => $user,
            "userModel" => $userModel
        ];

    }

    public function store(){



    }

    public function uploadImage(Request $request){

        //validator

        $task = new Task();

        $task->title = request()->input('title');
        $task->content = request()->input('content');

        $task->save();

//        $file = request()->file('image');

//        $path = Storage::disk('s3')->put('taskImage/'.$task->id, $file);
        $path = $request->file('image')->store('images', 's3');
//        Storage::disk('s3')->setVisibility($path, 'public');
        $storageName = basename($path);

        $task->filename = $storageName;
        $task->imageUrl = Storage::disk('s3')->url($path);
        $task->save();


        return [
            'data' => $task
        ];

    }
}
