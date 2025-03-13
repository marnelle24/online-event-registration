<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Log;

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

    public function create()
    {
        return view('admin.ministry.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ministries',
            'bio' => 'nullable|string',
            'bio' => 'nullable|string',
            'contactPerson' => 'nullable|string',
            'contactNumber' => 'nullable|string',
            'contactEmail' => 'nullable|email',
            'websiteUrl' => 'nullable|string',
        ], [
            'name.unique' => 'Ministry name already exists',
            'name.required' => 'Ministry name is required',
            'name.string' => 'Ministry name must be a string',
            'name.max' => 'Ministry name must be less than 255 characters',
            'bio.string' => 'Bio must be a string',
            'contactPerson.string' => 'Contact person must be a string',
            'contactNumber.string' => 'Contact number must be a string',
            'contactEmail.email' => 'Contact email must be a valid email address',
            'websiteUrl.string' => 'Website URL must be a string',
        ]);
        
        try 
        {   
            $requestedBy = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $validated['requestedBy'] = $requestedBy;
            $validated['searcheable'] = $request->searcheable;
            $validated['publishabled'] = $request->publishabled;
            $validated['status'] = $request->status;

            $ministry = Ministry::create($validated);

            if($ministry)
            {
                Toaster::success('Ministry created successfully');
                return redirect()
                    ->route('admin.ministry.edit', $ministry->id)
                    ->with('success', 'Ministry created successfully');
            }

        } 
        catch (\Exception $e) 
        {
            Log::error('Ministry creation failed: ' . $e->getMessage());
            Toaster::error('Failed to create ministry. Please try again.');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create ministry. Please try again.');
        }
    }

    public function edit($id)
    {
        try 
        {
            $ministry = Ministry::where('id', $id)->with('users')->first();
            return view('admin.ministry.edit', compact('ministry'));
        } 
        catch (\Exception $e) 
        {
            Log::error('Ministry not found: ' . $e->getMessage());
            Toaster::error('Ministry not found');
            return redirect()
                ->route('admin.ministries')
                ->with('error', 'Ministry not found');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ministries,name,' . $id,
            'bio' => 'nullable|string',
            'bio' => 'nullable|string',
            'contactPerson' => 'nullable|string',
            'contactNumber' => 'nullable|string',
            'contactEmail' => 'nullable|email',
            'websiteUrl' => 'nullable|string',
        ], [
            'name.unique' => 'Ministry name already exists',
            'name.required' => 'Ministry name is required',
            'name.string' => 'Ministry name must be a string',
            'name.max' => 'Ministry name must be less than 255 characters',
            'bio.string' => 'Bio must be a string',
            'contactPerson.string' => 'Contact person must be a string',
            'contactNumber.string' => 'Contact number must be a string',
            'contactEmail.email' => 'Contact email must be a valid email address',
            'websiteUrl.string' => 'Website URL must be a string',
        ]);

        try 
        {
            $validated['searcheable'] = $request->searcheable;
            $validated['publishabled'] = $request->publishabled;
            $validated['status'] = $request->status;
            
            $ministry = Ministry::findOrFail($id);
            $updated = $ministry->update($validated);

            if($updated)
            {
                Toaster::success('Ministry updated successfully');
                return redirect()
                    ->route('admin.ministries')
                    ->with('success', 'Ministry updated successfully');
            }
        } 
        catch (\Exception $e) 
        {
            Log::error('Ministry update failed: ' . $e->getMessage());
            Toaster::error('Failed to update ministry. Please try again.');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update ministry. Please try again.');
        }
    }
}
