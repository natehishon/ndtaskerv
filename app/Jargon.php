<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Jargon extends Model
{

    protected $appends = [
        'searchType',
        'formattedDate'
    ];

    public function jots()
    {
        return $this->morphMany('App\Jot', 'jotable');
    }

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function getSearchTypeAttribute(){
        return 'App\Jargon';
    }

    public function getFormattedDateAttribute(){
        return $this->created_at ? date_format($this->created_at, 'm/d/yy') : null;
    }

}
