<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{

    public function searchable()
    {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setData($userChoice, $userQuery){
    }

}