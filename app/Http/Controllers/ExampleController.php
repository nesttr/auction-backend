<?php

namespace App\Http\Controllers;

use App\Models\Auction;

class ExampleController extends Controller
{
    public function index(string $uuid)
    {
        $auction = Auction::query()->where('uuid', $uuid)->with('pigeon.images')->first();
        return view('welcome',['auction'=>$auction]);
    }
}
