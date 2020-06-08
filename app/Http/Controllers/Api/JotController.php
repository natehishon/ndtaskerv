<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Jot;
use App\SubTask;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JotController extends Controller
{

    public function index()
    {
        $user = JWTAuth::user();
        return Jot::query()->where("user_id", "=", $user->id)->orderBy('created_at')->get();

    }

    public function show($id)
    {

        $jot = Jot::query()->with('jotResponses')->with('user')->findOrFail($id);

        return [
            "data" => $jot,
        ];

    }

    public function store(Request $request)
    {

        $user = JWTAuth::user();
        $jot = new Jot();
        $jot->user_id = $user->id;
        $jot->title = "yo";
        $jot->content = $request->input('content');


        if ($request->input('jotable')) {
            switch ($request->input('jotable')['searchType']) {
                case "App\SubTask":
                    $subTask = SubTask::query()->find($request->input('jotable')['id']);
                    $subTask->jots()->save($jot);

                    break;
            }
        }


        $jot->save();


        return $jot;

    }

}
