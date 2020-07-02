<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Jot extends Model
{

    protected $appends = [
        'formattedDate'
    ];

    protected $types = [
        'subTask' => 'App\SubTask',
    ];

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
        return $this->hasMany(JotResponse::class, 'jot_id')->with('user');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedDateAttribute(){
        return $this->created_at ? date_format($this->created_at, 'm/d/yy') : null;
    }


//    public function subTasks()
//    {
//        return $this->morphedByMany('App\SubTask', 'jotable');
//    }

}
