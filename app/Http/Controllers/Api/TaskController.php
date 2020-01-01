<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Http\Resources\TaskShowResource;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {

        return TaskIndexResource::collection(
            Task::all()
        );

    }

    public function show($id) {

        return new TaskShowResource(Task::findOrFail($id));

    }
}
