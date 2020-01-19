<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{

    protected $appends = ['cover'];

    public function getCoverAttribute() {
        return $this->imageUrl;
    }

    public function task() {
        return $this->belongsTo(Task::class, 'task_id');
    }


}
