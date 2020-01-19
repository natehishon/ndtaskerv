<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function taskTrackings()
    {
        return $this->hasMany(TaskTracking::class, 'task_id');
    }

    public function subTask() {
        return $this->hasMany(SubTask::class, 'task_id');
    }
}
