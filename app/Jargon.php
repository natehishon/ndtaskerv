<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jargon extends Model
{

    protected $appends = [
        'searchType'
    ];

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function getSearchTypeAttribute(){
        return 'App\Jargon';
    }

}