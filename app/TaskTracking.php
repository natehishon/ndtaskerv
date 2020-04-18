<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTracking extends Model
{
    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function folder(){
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}
