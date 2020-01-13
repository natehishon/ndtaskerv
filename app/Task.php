<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function taskTrackings()
    {
        return $this->hasMany(TaskTracking::class);
    }
}
