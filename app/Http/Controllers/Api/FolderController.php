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

        return [
            "data" => Folder::query()->user()->where('name', '=', $name)->get(),
        ];

    }

}