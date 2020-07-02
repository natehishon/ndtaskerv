<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{

    protected $appends = [
        'imagePath',
        'searchType',
        'type',
        'formattedDate'

    ];

    public function getFormattedDateAttribute(){
        return date_format($this->created_at, 'm/d/yy') ?? null;
    }

    public function taskTrackings()
    {
        return $this->hasMany(TaskTracking::class, 'task_id');
    }

    public function subTask()
    {
        return $this->hasMany(SubTask::class, 'task_id')->orderBy('sort_order');
    }

    public function taskTag()
    {
        return $this->belongsToMany('App\TaskTag', 'task_tag_task',
            'taskID', 'taskTagID');
    }

    public function searchHistories()
    {
        return $this->morphMany('App\SearchHistory', 'searchable');
    }

    public function getImagePathAttribute()
    {
        return 'https://ndtask.s3.us-east-2.amazonaws.com/taskImage/' . $this->id . '/';
    }

    public function jots()
    {
        return $this->morphMany('App\Jot', 'jotable');
    }

    public function prebuiltFolders()
    {
        return $this->belongsToMany('App\PrebuiltFolders');
    }

    public function getSearchTypeAttribute()
    {
        return 'App\Task';
    }

    public function getTypeAttribute()
    {
        return 'task';
    }

    public function setSubTasks($subTasks, $imageFiles)
    {
        foreach ($subTasks as $key => $subTask) {
            if (empty($subTask['id'])) {

                if ($subTask['active'] === false) {
                    continue;
                }

                $newSubTask = new SubTask();
                $newSubTask->title = $subTask['title'];
                $newSubTask->content_html = $subTask['content_html'];
                $newSubTask->content = strip_tags($subTask['content']);

                $newSubTask->media_type = "image";

                $newSubTask->task()->associate($this);


            } else {
                $newSubTask = SubTask::query()->find($subTask['id']);
                if (empty($newSubTask)) {
                    continue;
                }

                if ($subTask['active'] === false) {
                    $newSubTask->delete();
                    continue;
                }

                $newSubTask->title = $subTask['title'];
                $newSubTask->content_html = $subTask['content_html'];
                $newSubTask->content = strip_tags($subTask['content']);
                $newSubTask->media_type = "image";
            }

            if ((isset($subTask['fileKey']) && !empty($subTask['fileKey']))) {
                if ($imageFiles[$subTask['fileKey']]) {
                    $path = $imageFiles[$subTask['fileKey']]->store('images', 's3');
                    $newSubTask->image_url = Storage::disk('s3')->url($path);

                    $imageTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
                    $videoTypes = ['video/mp4', 'video/ogg', 'video/webm'];

                    if (in_array($imageFiles[$subTask['fileKey']]->getMimeType(), $imageTypes)) {
                        $newSubTask->media_type = 'image';
                    }

                    if(in_array($imageFiles[$subTask['fileKey']]->getMimeType(), $videoTypes) ){
                        $newSubTask->media_type = 'video';
                    }

                }
            }
            $newSubTask->sort_order = $key;

            $newSubTask->save();
        }
    }


}
