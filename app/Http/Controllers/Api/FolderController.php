<?php


namespace App\Http\Controllers\Api;

use App\Folder;
use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FolderController extends Controller
{

    public function index()
    {
        return [
            "table" => Folder::query()->user()->topLevel()->get(),
        ];
    }

    public function userFolders($userId)
    {
        $folders = Folder::query()->where('user_id', '=', $userId)->where('top_level', '=',true)->with('taskTrackings.tasks')->with('childrensChildren')->get();
        $tasks = Task::query()->get();
        return [
            "folders" => $folders,
            "tasks" => $tasks
        ];
    }

    public function destroy($id)
    {
        $folders = Folder::query()->findOrFail($id);
        $folders->delete();
        return [
            "success" => true,
        ];
    }

    public function folderByName($name)
    {

        $folder = Folder::query()->user()->where('slug', '=', $name)->first();
        $subFolders = $folder->children->toArray();
        $taskTrackings = $folder->taskTrackings()->with('tasks.subTask')->get()->toArray();
        $tasks = array_column($taskTrackings, 'tasks');


        return [
            'subFolders' => $subFolders,
            'taskTrackings' => $taskTrackings,
            'table' => array_merge($subFolders, $tasks)
        ];

    }

    public function store(Request $request, $userID){

        $folder = new Folder();

        if(!empty($request->file('folderFile'))){

            $path = $request->file('folderFile')->store('images', 's3');

            $folder->imageUrl = Storage::disk('s3')->url($path);
        }

        $userInput = json_decode($request->input('folder'), true);

        $folder->title = $userInput['title'];
        $folder->user_id = $userID;
        $folder->slug = urlencode($folder->title);

        if($userInput['isTopLevel'] === true){
            $folder->top_level = true;
        }

        if(!empty($userInput['parent_id'])){
            $folder->parent_id = $userInput['parent_id'];
        }

        $folder->save();

        return $folder;

    }



}
