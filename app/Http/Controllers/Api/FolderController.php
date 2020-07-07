<?php


namespace App\Http\Controllers\Api;

use App\Folder;
use App\Http\Controllers\Controller;
use App\PrebuiltFolder;
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
        $folders = Folder::query()->where('user_id', '=', $userId)->where('top_level', '=', true)->with('taskTrackings.tasks')->with('childrensChildren')->get();
        $tasks = Task::query()->get();
        return [
            "folders" => $folders,
            "tasks" => $tasks
        ];
    }

    public function prebuiltFolders()
    {
        $folders = PrebuiltFolder::query()->with('tasks')->get();
        return [
            "folders" => $folders,
        ];
    }

    public function storePrebuiltTask($id, Request $request)
    {
        $prebuiltFolder = PrebuiltFolder::query()->find($id);
        $task = Task::query()->find($request->input('taskID'));

        $prebuiltFolder->tasks()->save($task);
//        $prebuiltFolder->save();

        return $prebuiltFolder->with('tasks')->get();

    }

    public function getPrebuiltFolder($id)
    {
        return [
         "prebuiltFolder" => PrebuiltFolder::query()->with('tasks')->find($id),
         "tasks" => Task::query()->get()
        ];
    }

    public function destroy($id)
    {
        $folder = Folder::query()->findOrFail($id);
        Folder::deleteAll($folder);
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

    public function store(Request $request, $userID)
    {

        $folder = new Folder();

        if (!empty($request->file('folderFile'))) {

            $path = $request->file('folderFile')->store('images', 's3');

            $folder->image_url = Storage::disk('s3')->url($path);
        }

        $userInput = json_decode($request->input('folder'), true);

        $folder->title = $userInput['title'];
        $folder->user_id = $userID;
        $folder->slug = urlencode($folder->title);

        if ($userInput['isTopLevel'] === true) {
            $folder->top_level = true;
        }

        if (!empty($userInput['parent_id'])) {
            $folder->parent_id = $userInput['parent_id'];
        }

        $folder->save();

        $folders = Folder::query()->where('user_id', '=', $userID)->where('top_level', '=', true)->with('taskTrackings.tasks')->with('childrensChildren')->get();
        $tasks = Task::query()->get();
        return [
            "folders" => $folders,
            "tasks" => $tasks
        ];

    }


}
