<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Jot extends Model
{

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function jotable()
    {
        return $this->morphTo();
    }

}