<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Programme;
use Illuminate\Http\Request;

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
        $categories = Category::all();
        return view('admin.programme.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'programmeCode' => 'required|unique:programmes,programmeCode',
            'type' => 'required|in:course,event',
            'excerpt' => 'nullable|max:255',
            'description' => 'nullable',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after:startDate',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'customDate' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'postalCode' => 'nullable',
            'country' => 'nullable',
            'latLong' => 'nullable',
            'price' => 'nullable|numeric|min:0|max:100',
            'adminFee' => 'nullable|numeric|min:0|max:100',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'a3_poster' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'contactNumber' => 'nullable',
            'contactPerson' => 'nullable',
            'contactEmail' => 'nullable|email',
            'limit' => 'nullable|numeric|min:0|max:100',
            'settings' => 'nullable|json',
            'extraFields' => 'nullable|json',
            'searchable' => 'nullable|boolean',
            'publishable' => 'nullable|boolean',
            'private_only' => 'nullable|boolean',
            'externalUrl' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
        ]);

        dd($validated, $request->all());


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
