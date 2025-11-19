<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetronomeController extends Controller
{
    public function index()
    {
        return view('metronome.index');
    }
}
