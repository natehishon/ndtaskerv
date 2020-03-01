<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $appends = [
        'imagePath'
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

    public function getImagePathAttribute(){
        return 'https://ndtask.s3.us-east-2.amazonaws.com/taskImage/'.$this->id .'/';
    }


}
