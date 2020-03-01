<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class TaskTag extends Model
{
//    protected $table = 'ndtask.task_tag';
    public function task()
    {
        return $this->belongsToMany('App\Task', 'task_tag_task',
            'taskTagID', 'taskID');
    }

}