<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class Folder extends Model
{

    protected $appends = [
        'searchType',
        'modelName'
    ];

    public function parent()
    {
        return $this->belongsTo('Folder', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Folder', 'parent_id');
    }

    public function owner()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function scopeTopLevel($query)
    {
        return $query->where('top_level', '=', true);
    }

    public function scopeUser($query)
    {
        $user = JWTAuth::user();
        return $query->where('user_id', '=', $user->id);
    }

    public function getSearchTypeAttribute(){
        return 'App\Folder';
    }

    public function getModelNameAttribute(){
        return 'Folder';
    }


}