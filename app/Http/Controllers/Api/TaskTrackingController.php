<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\TaskTracking;
use App\User;
use Illuminate\Http\Request;
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
    public function destroy($id)
    {
        $tracking = TaskTracking::query()->findOrFail($id);
        $tracking->delete();
        return [
            "success" => true,
        ];

    }

    public function store(Request $request, $id)
    {

        $tracking = new TaskTracking();
        $tracking->user_id = $id;
        $tracking->folder_id = $request->input('folderID');
        $tracking->task_id = $request->input('taskID');

        $tracking->save();

        return [
            "data" => $tracking
        ];

    }

}
