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

    public function jotResponses()
    {
        return $this->hasMany(JotResponse::class, 'jot_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

//    public function subTasks()
//    {
//        return $this->morphedByMany('App\SubTask', 'jotable');
//    }

}
