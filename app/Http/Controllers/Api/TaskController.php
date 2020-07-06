<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    public function index()
    {
        return [
            "data" => Task::query()->with('subTask')->get(),
        ];

    }

    public function show($id)
    {

        $task = Task::query()->with('subTask')->findOrFail($id);

        return [
            "data" => $task,
        ];

    }

    public function update(Request $request, $id)
    {

        $task = Task::query()->with('subTask')->findOrFail($id);

        $userInput = json_decode($request->input('task'), true);

        $task->title = $userInput['title'];

        if(!empty($userInput['content_html'])){
            $task->content_html = $userInput['content_html'];
            $task->content = strip_tags($userInput['content_html']);
        }

        if(!empty($request->file('taskFile'))){

            $path = $request->file('taskFile')->store('images', 's3');

            $imageTypes=['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $videoTypes=['video/mp4', 'video/ogg', 'video/webm'];
            if(in_array($request->file('taskFile')->getMimeType(), $imageTypes) ){
                $task->media_type = 'image';
            }

            if(in_array($request->file('taskFile')->getMimeType(), $videoTypes) ){
                $task->media_type = 'video';
            }


            $task->filename = $request->file('taskFile')->getClientOriginalName();
            $task->image_url = Storage::disk('s3')->url($path);
        }

        $task->setSubTasks($userInput['sub_task'], $request->file());

        $task->save();

        return  $task->with('subTask')->findOrFail($id);
    }

    public function store(Request $request){

        $task = new Task();

        if(!empty($request->file('taskFile'))){
            $path = $request->file('taskFile')->store('images', 's3');

            $imageTypes=['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $videoTypes=['video/mp4', 'video/ogg', 'video/webm'];
            if(in_array($request->file('taskFile')->getMimeType(), $imageTypes) ){
                $task->media_type = 'image';
            }

            if(in_array($request->file('taskFile')->getMimeType(), $videoTypes) ){
                $task->media_type = 'video';
            }


            $task->filename = $request->file('taskFile')->getClientOriginalName();
            $task->image_url = Storage::disk('s3')->url($path);
        }

        $userInput = json_decode($request->input('task'), true);

        $task->title = $userInput['title'];
        $task->content_html = $userInput['content_html'];
        $task->content = strip_tags($userInput['content_html']);


        $task->save();

        if(isset($userInput['sub_task'])){
            $task->setSubTasks($userInput['sub_task'], $request->file());
        }

        return $task->with('subTask')->findOrFail($task->id);

    }
}
