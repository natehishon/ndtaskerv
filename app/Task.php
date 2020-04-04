<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $appends = [
        'imagePath',
        'searchType'
    ];

    public function taskTrackings()
    {
        return $this->hasMany(TaskTracking::class, 'task_id');
    }

    public function subTask() {
        return $this->hasMany(SubTask::class, 'task_id');
    }

    public function taskTag()
    {
        return $this->belongsToMany('App\TaskTag', 'task_tag_task',
            'taskID', 'taskTagID');
    }

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function getImagePathAttribute(){
        return 'https://ndtask.s3.us-east-2.amazonaws.com/taskImage/'.$this->id .'/';
    }

    public function getSearchTypeAttribute(){
        return 'App\Task';
    }


}
