<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $fields  = Fields::all();
        return view('schedules', compact('fields'));
    }
}
