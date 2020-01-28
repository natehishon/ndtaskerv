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
        '',
        ''
    ];

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

    }

    public function store(){



    }

    public function uploadImage(){

        //validator

        $task = new Task();

        $task->title = request()->input('title');
        $task->content = request()->input('title');

        $task->save();

        $file = request()->file('image');

        $path = Storage::disk('s3')->put('taskImage/'.$task->id, $file);
        $storageName = basename($path);

        $task->imageUrl = $storageName;
        $task->save();

//        Storage::putFileAs(
//            'taskImage/'.$task->id, request()->file('image'), request()->file('image')->getClientOriginalName()
//        );
        return [
            'data' => $task
        ];

    }
}
