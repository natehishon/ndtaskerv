<?php


namespace App\Http\Controllers\Api;

use App\Folder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    public function index()
    {

        return [
            "data" => Folder::query()->user()->topLevel()->get(),
        ];

    }

    public function folderByName($name)
    {

        $folder = Folder::query()->user()->where('title', '=', $name)->first();
        $subFolders = $folder->children->toArray();
        $taskTrackings = $folder->taskTrackings()->with('tasks.subTask')->get()->toArray();
        $tasks = array_column($taskTrackings, 'tasks');


        return [
            'subFolders' => $subFolders,
            'taskTrackings' => $taskTrackings,
            'table' => array_merge($subFolders, $tasks)
        ];

    }

}