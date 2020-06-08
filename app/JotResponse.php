<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class JotResponse extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jot()
    {

        return $this->belongsTo(Jot::class, 'jot_id');

    }

}
