<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Jargon;
use App\Jot;
use App\JotResponse;
use App\SubTask;
use App\Task;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JotController extends Controller
{

    public function index()
    {
        $user = JWTAuth::user();
        return Jot::query()->where("user_id", "=", $user->id)->orderBy('created_at')->get();

    }

    public function adminIndex()
    {
        $subTasks = Jot::query()
            ->leftJoin('users', function ($q) {
                $q->on('users.id', '=', 'jots.user_id');
            })
            ->leftJoin('sub_tasks', function ($q) {
                $q->on('jots.jotable_id', '=', 'sub_tasks.id')
                ->where('jots.jotable_type', '=', 'App\SubTask');
            })

            ->leftJoin('tasks', function ($q) {
                $q->on('jots.jotable_id', '=', 'tasks.id')
                    ->where('jots.jotable_type', '=', 'App\Task');
            });

//        $tasks = Jot::query()->orderBy('jots.created_at')
//            ->leftJoin('users', function ($q) {
//                $q->on('users.id', '=', 'jots.user_id');
//            })
//            ->leftJoin('tasks', function ($q) {
//                $q->on('jots.jotable_id', '=', 'tasks.id');
//            })->where('jots.jotable_type', '=', 'App\Task')
//            ->get(['jots.id', 'jots.title', 'jots.jotable_type', 'jots.created_at', 'users.name as user']);

//        $collected = array_merge($subTasks->toArray());

        return $subTasks->get(['jots.id', 'jots.title', 'jots.jotable_type', 'jots.created_at', 'users.name as user']);

    }

    public function show($id)
    {

        $jot = Jot::query()->with('jotResponses')->with('jotable')->with('user')->findOrFail($id);

        return [
            "data" => $jot,
        ];

    }

    public function jotComment(Request $request, $id)
    {
        $user = JWTAuth::user();
        $jot = Jot::query()->find($id);
        $jotComment = new JotResponse();
        $jotComment->content_html = $request->input('comment');
        $content = strip_tags($request->input('comment'));
        $content = str_replace("&nbsp;", "", $content);

        $jotComment->content = $content;

        $jotComment->user()->associate($user);
        $jotComment->jot()->associate($jot);
        $jotComment->save();

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
        $jot->title = $request->input('title');
        $jot->content_html = $request->input('content');
        $content = strip_tags($request->input('content'));
        $content = str_replace("&nbsp;", "", $content);

        $jot->content = $content;


        if ($request->input('jotable')) {
            switch ($request->input('jotable')['searchType']) {
                case "App\SubTask":
                    $subTask = SubTask::query()->find($request->input('jotable')['id']);
                    $subTask->jots()->save($jot);
                    break;
                case "App\Task":
                    $task = Task::query()->find($request->input('jotable')['id']);
                    $task->jots()->save($jot);
                    break;
                case "App\Jargon":
                    $jargon = Jargon::query()->find($request->input('jotable')['id']);
                    $jargon->jots()->save($jot);
                    break;
            }
        }


        $jot->save();


        return $jot;

    }

}
