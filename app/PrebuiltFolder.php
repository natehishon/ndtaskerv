<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class PrebuiltFolder extends Model
{

    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }

}
