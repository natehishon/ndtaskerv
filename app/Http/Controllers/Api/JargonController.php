<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jargon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class JargonController extends Controller
{


    public function index()
    {
        return [
            "data" => Jargon::query()->get(),
        ];

    }

    public function show($id)
    {

        $jargon = Jargon::query()->findOrFail($id);

        return [
            "data" => $jargon,

        ];

    }


    public function getByTitle($title)
    {

        $jargon = Jargon::query()->where('title', 'like', '%' . $title . '%')->first();


        return [
            "data" => $jargon,

        ];

    }

    public function store(Request $request){

        $jargon = new Jargon();

        $jargon->title = request()->input('title');
        $jargon->content = request()->input('content');
        $jargon->color = 'primary';

        if(!empty($request->file('image'))){
            $path = $request->file('image')->store('images', 's3');
            $storageName = basename($path);
//            $jargon->filename = $storageName;
            $jargon->imageUrl = Storage::disk('s3')->url($path);
        }

        $jargon->save();

        return $jargon;

    }

    public function update(Request $request, $id)
    {
        $jargon = Jargon::query()->findOrFail($id);

        $jargon->title = request()->input('title');
        $jargon->content = request()->input('content');

        if(!empty($request->file('image'))){
            $path = $request->file('image')->store('images', 's3');
            $storageName = basename($path);
//            $jargon->filename = $storageName;
            $jargon->imageUrl = Storage::disk('s3')->url($path);
        }

        $jargon->save();

        return  $jargon;
    }


}
