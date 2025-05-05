<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Programme;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgrammeRequest;

class ProgrammeController extends Controller
{

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:2048',
        ]);

        $programme = Programme::first() ?? Programme::create(['programmeCode' => '1232131', 'title' => 'temp']); // Just attach to any post for now

        $media = $programme->addMediaFromRequest('upload')->toMediaCollection('images');

        return response()->json([
            'url' => $media->getUrl(),
            'uploaded' => 1,
            'fileName' => $media->file_name,
        ]);
        
    }

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
        $categories = Category::all();
        return view('admin.programme.create', compact('categories'));
    }

    public function store(StoreProgrammeRequest $request)
    {
        // $validated = $request->validated();

        dd($validated);


        return view('admin.programme.store');
    }

    public function show()
    {
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
