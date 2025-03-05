<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function index()
    {
        $ministries = Ministry::all();
        return view('admin.ministry.index', compact('ministries'));
    }

    // public function create()
    // {
    //     return view('admin.ministries.create');
    // }
    
    
}
