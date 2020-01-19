<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }


}
