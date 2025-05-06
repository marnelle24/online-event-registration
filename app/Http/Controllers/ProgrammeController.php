<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ministry;
use App\Models\Programme;
use App\Models\EditorUpload;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgrammeRequest;

class ProgrammeController extends Controller
{

    public function index(Request $request)
    {
        $searchQuery = $request->get('search');

        $programmes = Programme::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('title', 'like', "%{$searchQuery}%");
            $query->orWhere('programmeCode', 'like', "%{$searchQuery}%");
        })
        ->with('categories')
        ->latest()
        ->paginate(10);

        return view('admin.programme.index', compact('searchQuery', 'programmes'));
    }

    public function create()
    {
        $ministries = Ministry::pluck('name', 'id');
        $categories = Category::all();
        return view('admin.programme.create', compact(['categories', 'ministries']));
    }

    public function store(StoreProgrammeRequest $request)
    {

        $validated = $request->validated();
        $validated['ministry_id'] = 1;

        $programme = Programme::create($validated);
        $programme->addMediaFromRequest('thumb')->toMediaCollection('thumbnail');
        $programme->addMediaFromRequest('a3_poster')->toMediaCollection('banner');

        return back();


        // return view('admin.programme.store');
    }

    public function show($id)
    {
        $programme = Programme::whereId($id)->first();
        $thumbnail = $programme->getFirstMedia('thumbnail')->getUrl();
        $banner = $programme->getFirstMedia('banner')->getUrl();
        
        dd($programme, $thumbnail, $banner);

        return view('admin.programme.show');
    }

    public function edit()
    {
        return view('admin.programme.edit');
    }

    public function update()
    {
        return view('admin.programme.update');
    }

    public function destroy()
    {
        return view('admin.programme.destroy');
    }
    
}
