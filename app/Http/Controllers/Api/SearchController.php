<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\SearchHelper;
use App\Jargon;
use App\SearchHistory;
use App\Task;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class SearchController extends Controller
{

    public function historyChoice(Request $request)
    {
        $searchHistory = SearchHistory::query()->findOrFail($request->input('id'));
        $searchHistory->choice_count++;
        $searchHistory->save();
        return [
            "success" => true
        ];

    }

    public function userSearch(Request $request)
    {
        $searchWord = $request->input('search');
        $searchHelper = new SearchHelper();
        $taskResults = $searchHelper->modelSearch('tasks', $searchWord);
        $jargonResults = $searchHelper->modelSearch('jargons', $searchWord);
        $folderResults = $searchHelper->titleSearch('folders', $searchWord);
        $jotResults = $searchHelper->modelSearch('jots', $searchWord);
        $searchHistories = $searchHelper->userHistory($searchWord);


        return [
            'tasks' => $taskResults,
            'jargons' => $jargonResults,
            'history' => $searchHistories,
            'jots' => $jotResults,
            'folders' => $folderResults,
        ];

    }

    public function userChoice(Request $request)
    {

        $user = JWTAuth::user();
        $userChoice = $request->input('choice');
        $userQuery = $request->input('search');
        $type = $userChoice['searchType'];


        $searchHistory = SearchHistory::query()
            ->where('user_id', '=', $user->id)
            ->where('searchable_id', '=', $userChoice['id'])
            ->where('searchable_type', '=', $userChoice['searchType'])
            ->where('search_query', 'like', '%' . $userQuery . '%')
            ->first();

        if (empty($searchHistory)) {
            $searchHistory = new SearchHistory();
            $searchHistory->search_query = $userQuery;
            $searchHistory->user()->associate($user);
            $searchHistory->choice_count = 1;


            switch ($type) {
                case 'App\Task':
                    $task = Task::query()->findOrFail($userChoice['id']);
                    $task->searchHistories()->save($searchHistory);
                    break;
                case 'App\Jargon':
                    $jargon = Jargon::query()->findOrFail($userChoice['id']);
                    $jargon->searchHistories()->save($searchHistory);
                    break;
            }
        } else {
            $searchHistory->choice_count++;
            $searchHistory->save();
        }


//


    }

}