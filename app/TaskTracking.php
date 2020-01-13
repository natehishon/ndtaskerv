<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTracking extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
