<?php

namespace App\Helpers;


use App\Folder;
use App\Jargon;
use App\Jot;
use App\SearchHistory;
use App\Task;
use Illuminate\Support\Facades\DB;

class SearchHelper
{
    // Remove unnecessary words from the search term and return them as an array
    function filterSearchKeys($query)
    {
        $query = trim(preg_replace("/(\s+)+/", " ", $query));
        $words = array();
        $list = array("in", "it", "a", "the", "of", "or", "I", "you", "he", "me", "us", "they", "she", "to", "but", "that", "this", "those", "then");
        $c = 0;
        foreach (explode(" ", $query) as $key) {
            if (in_array($key, $list)) {
                continue;
            }
            $words[] = $key;
            if ($c >= 15) {
                break;
            }
            $c++;
        }
        return $words;
    }

    function limitChars($query, $limit = 200)
    {
        return substr($query, 0, $limit);
    }

    function escape_like($string)
    {
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $search = array('%', '');
        $replace = array('\%', '');
        return str_replace($search, $replace, $string);
    }

    function userHistory($userQuery)
    {
        $searchHistories = SearchHistory::query()->
        where('search_query', 'like', '%' . $userQuery . '%')->
        orderByDesc('choice_count')->
        limit(3)->
        with('searchable')->
        get();


//        foreach ($searchHistories as $history) {
//            array_filter($newList, function($toCheck) use ($history) {
//                dd($history);
////                dd('yo');
////                 dd($toCheck->searchable_id == $history->searchable_id && $toCheck->searchable_type == $history->searchable_type);
//            });
//        }

        return $searchHistories;

    }

    function titleSearch($model, $query)
    {

        //ready our query
        $query = trim($query);
        if (mb_strlen($query) === 0) {
            return false;
        }
        $query = $this->limitChars($query);
        $keywords = $this->filterSearchKeys($query);
        $escQuery = $this->escape_like($query);
        $titleSQL = array();

        //set scores
        $scoreExactMatchTitle = 6;
        $scoreFullTitle = 4;
        $scoreTitleKeyword = 3;


        //escaped query in total
        if (count($keywords) > 0) {
            $titleSQL[] = "(case when title = '" . $escQuery . "' then {$scoreExactMatchTitle} else 0 end)";
            $titleSQL[] = "(case when title LIKE '%" . $escQuery . "%' then {$scoreFullTitle} else 0 end)";

        }


        //going through each word
        foreach ($keywords as $key) {
            $titleSQL[] = "(case when title LIKE '%" . $this->escape_like($key) . "%' then {$scoreTitleKeyword} else 0 end)";
        }


        if (empty($titleSQL)) {
            $titleSQL[] = 0;
        }


        $sql = "SELECT t.id,t.title,t.created_at,
            
            (
                (" . implode(" + ", $titleSQL) . ")
            ) as score
            FROM " . $model . " t
           
           group by t.id, t.title,t.created_at
            HAVING (
                (" . implode(" + ", $titleSQL) . ")
            ) > 0
            
            ORDER BY score DESC
            LIMIT 25";

        $results = DB::select(DB::raw($sql));

        if ($model === 'folders') {
            $models = Folder::hydrate($results);
        }

        if (!$results) {
            return [];
        }
        return $models;
    }

    function modelSearch($model, $query)
    {

        //ready our query
        $query = trim($query);
        if (mb_strlen($query) === 0) {
            return false;
        }
        $query = $this->limitChars($query);
        $keywords = $this->filterSearchKeys($query);
        $escQuery = $this->escape_like($query);
        $titleSQL = array();
        $contentSQL = array();

        //set scores
        $scoreExactMatchTitle = 6;
        $scoreExactMatchContent = 5;
        $scoreFullTitle = 4;
        $scoreTitleKeyword = 3;
        $scoreFullContent = 2;
        $scoreContentKeyword = 1;


        //escaped query in total
        if (count($keywords) > 0) {
            $titleSQL[] = "case when title = '" . $escQuery . " ' then {$scoreExactMatchTitle} else 0 end";
            $titleSQL[] = "(case when title LIKE '%" . $escQuery . "%' then {$scoreFullTitle} else 0 end)";
            $contentSQL[] = "(case when content = '" . $escQuery . "' then {$scoreExactMatchContent} else 0 end)";
            $contentSQL[] = "(case when content LIKE '%" . $escQuery . "%' then {$scoreFullContent} else 0 end)";

        }


        //going through each word
        foreach ($keywords as $key) {
            $titleSQL[] = "(case when title LIKE '%" . $this->escape_like($key) . "%' then {$scoreTitleKeyword} else 0 end)";
            $contentSQL[] = "(case when content LIKE '%" . $this->escape_like($key) . "%' then {$scoreContentKeyword} else 0 end)";
        }


        if (empty($titleSQL)) {
            $titleSQL[] = 0;
        }

        if (empty($contentSQL)) {
            $contentSQL[] = 0;
        }


        $sql = "SELECT t.id,t.title,t.created_at,
            t.content,
            (
                (" . implode(" + ", $titleSQL) . ")
                +
                (" . implode(" + ", $contentSQL) . ")
            ) as score
            FROM " . $model . " t
           group by t.id,t.title,t.created_at,
            t.content
            HAVING (
                (" . implode(" + ", $titleSQL) . ")
                +
                (" . implode(" + ", $contentSQL) . ")
            ) > 0
            ORDER BY score DESC
            LIMIT 25";

        //TODO
        //more models, jargons
        //one known bug is to implement a set ON object properties
        //important, should make these models implement a searchable interface
        //user scope these

        //running the actual query
//        dd($sql);
        $results = DB::select(DB::raw($sql));

        if ($model === 'tasks') {
            $models = Task::hydrate($results);
        }

        if ($model === 'jargons') {
            $models = Jargon::hydrate($results);
        }

        if ($model === 'jots') {
            $models = Jot::hydrate($results);
        }

        if (!$results) {
            return [];
        }
        return $models;
    }

}