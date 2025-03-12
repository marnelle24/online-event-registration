<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->get('search');

        $ministries = Ministry::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })
        ->latest()
        ->paginate(10);

        return view('admin.ministry.index', compact('searchQuery', 'ministries'));
    }

    public function show($id)
    {
        try 
        {
            $ministry = Ministry::find($id);
            return view('admin.ministry.show', compact('ministry'));
        } 
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Ministry not found');
        }
    }
    
    
}
