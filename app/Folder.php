<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class Folder extends Model
{

    protected $appends = [
        'searchType',
        'modelName',
        'type'
    ];

    protected $table = 'user_folders';

    public function parent()
    {
        return $this->belongsTo('App\Folder', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Folder', 'parent_id')->with('taskTrackings.tasks');
    }

    public function childrensChildren()
    {
        return $this->hasMany('App\Folder', 'parent_id')->with(['childrensChildren', 'taskTrackings.tasks']);
    }

    public function taskTrackings()
    {
        return $this->hasMany('App\TaskTracking', 'folder_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
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

    public function allParents(){
        return $this->parent()->with('allParents');
    }


    public function getFullSlug(){
        return $this->allParents;

    }

    public function getSearchTypeAttribute(){
        return 'App\Folder';
    }

    public function getModelNameAttribute(){
        return 'Folder';
    }

    public function getTypeAttribute(){
        return 'folder';
    }


}
