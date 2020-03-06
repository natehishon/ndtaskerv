<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jargon;


class JargonController extends Controller
{


    public function index()
    {
        return [
            "data" => Jargon::query()->get(),
        ];

    }


    public function getByTitle($title)
    {

        $jargon = Jargon::query()->where('title', 'like', '%' . $title . '%')->first();


        return [
            "data" => $jargon,

        ];

    }


}
