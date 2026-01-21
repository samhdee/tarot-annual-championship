<?php

namespace App\Http\Controllers;

class MeetController extends Controller
{
    public function index()
    {
        return view('meet.index');
    }

    public function add()
    {
        return view('meet.add');
    }
}
