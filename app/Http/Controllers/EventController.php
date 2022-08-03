<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    public function index()
    {
        $events = auth()->user()->events()
            ->orderBy('started_at', 'desc')
            ->get();

        return view('events', compact('events'));
    }
}
