<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class JotAudit extends Model
{

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function jot() {
        return $this->belongsTo(Jot::class, 'jot_id');
    }

}
