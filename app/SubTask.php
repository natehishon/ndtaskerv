<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{

    protected $appends = [
        'searchType',
        'modelName'
    ];

    public function getCoverAttribute() {
        return $this->imageUrl;
    }

    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function jots()
    {
        return $this->morphMany('App\Jots', 'jotable');
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


}
