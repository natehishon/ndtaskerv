<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{

    protected $appends = [
        'searchType',
        'modelName',
        'active'
    ];

    public function getCoverAttribute() {
        return $this->imageUrl;
    }

    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function jots()
    {
        return $this->morphMany('App\Jot', 'model');
    }

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function getSearchTypeAttribute(){
        return 'App\SubTask';
    }

    public function getModelNameAttribute(){
        return 'subtask';
    }

    public function getActiveAttribute(){
        return true;
    }


}
