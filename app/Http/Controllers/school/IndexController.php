<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SchoolTimeTable;

class IndexController extends Controller
{
    public function index()
    {
        $school = \Auth::user();
        $name = $school->name;
        return view('school.top',compact('name'));
    }
}
