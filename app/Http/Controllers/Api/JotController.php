<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Jargon;
use App\Jot;
use App\JotAudit;
use App\JotResponse;
use App\SubTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class JotController extends Controller
{

    public function index()
    {
        $user = JWTAuth::user();
        return Jot::query()
            ->where("user_id", "=", $user->id)
            ->orderBy('created_at')
            ->leftJoin('jot_audits', function ($q) {
                $q->on('jots.id', '=', 'jot_audits.jot_id')
                    ->where('jot_audits.read', '=', false)
                    ->where('jot_audits.is_admin', '=', true);})
            ->groupBy('jots.id', 'jots.title', 'jots.jotable_type', 'jots.created_at')
            ->get(['jots.id', 'jots.title', 'jots.jotable_type', 'jots.created_at', DB::raw('count(jot_audits.id) as jot_count')]);

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
            })
            ->leftJoin('jot_audits', function ($q) {
                $q->on('jots.id', '=', 'jot_audits.jot_id')
                    ->where('jot_audits.read', '=', '0')
                    ->where('jot_audits.is_admin', '=', '0');
            })->groupBy('jots.id', 'users.name', 'jots.title', 'jots.jotable_type', 'jots.created_at');


        return $subTasks->get(['jots.id', 'jots.title', 'jots.jotable_type', 'jots.created_at', 'users.name as user', DB::raw('count(jot_audits.id) as jot_count')]);

    }

    public function show($id)
    {

        $jot = Jot::query()->with('jotResponses')->with('jotable')->with('user')->findOrFail($id);

        $user = JWTAuth::user();

        if($user->isAdmin){
            //if admin mark all user audits for this jot as read
            $jotAudits = JotAudit::query()->where('jot_id', '=', $jot->id)->where('is_admin', '=', 0)->get();
        } else {
            //if user mark all admin audits for this jot as read
            $jotAudits = JotAudit::query()->where('jot_id', '=', $jot->id)->where('is_admin', '=', 1)->get();
        }

        foreach ($jotAudits as $jotAudit) {
            $jotAudit->read = 1;
            $jotAudit->save();
        }



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

        $jotAudit = new JotAudit();
        $jotAudit->author()->associate($user);
        $jotAudit->jot()->associate($jot);
        if ($user->isAdmin === 1) {
            $jotAudit->is_admin = 1;
        }
        $jotAudit->save();

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

        $jotAudit = new JotAudit();
        $jotAudit->author()->associate($user);
        $jotAudit->jot()->associate($jot);
        if ($user->isAdmin === 1) {
            $jotAudit->is_admin = 1;
        }
        $jotAudit->save();


        return $jot;

    }

}
