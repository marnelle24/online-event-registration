<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->get('search');

        $speakers = Speaker::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })
        ->latest()
        ->paginate(10);

        return view('admin.speaker.index', compact('searchQuery', 'speakers'));
    }

    public function create()
    {
        return view('admin.speaker.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'profession' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'socials' => 'nullable|array',
            'socials.*.name' => 'required|string',
            'socials.*.url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        try 
        {
            // Process social media links
            $socials = [];
            if ($request->has('socials')) {
                foreach ($request->socials as $platform => $data) {
                    if (!empty($data['url'])) {
                        $socials[$platform] = [
                            'name' => $data['name'],
                            'url' => $data['url']
                        ];
                    }
                }
            }
            $validated['socials'] = $socials;

            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('speakers', 'public');
                $validated['thumbnail'] = $path;
            }

            $speaker = Speaker::create($validated);
            
            if($speaker) {
                Toaster::success('Speaker created successfully');
                return redirect()
                    ->route('admin.speakers')
                    ->with('success', 'Speaker created successfully');
            }
        } 
        catch (\Exception $e) 
        {
            Log::error('Speaker creation failed: ' . $e->getMessage());
            Toaster::error('Failed to create speaker. Please try again.');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create speaker. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $speaker = Speaker::where('id', $id)->with('programmes')->first();
            return view('admin.speaker.show', compact('speaker'));
        } catch (\Exception $e) {
            Toaster::error('Speaker not found');
            Log::error('Speaker not found: ' . $e->getMessage());
            return redirect()->route('admin.speakers');
        }
    }

    public function edit($id)
    {
        
        try {
            $speaker = Speaker::findOrFail($id);
            return view('admin.speaker.edit', compact('speaker'));
        } catch (\Exception $e) {
            Toaster::error('Speaker not found');
            Log::error('Speaker not found: ' . $e->getMessage());
            return redirect()->route('admin.speakers');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'profession' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'socials' => 'nullable|array',
            'socials.*.name' => 'required|string',
            'socials.*.url' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        try {
            $speaker = Speaker::findOrFail($id);

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($speaker->thumbnail) {
                    Storage::disk('public')->delete($speaker->thumbnail);
                }
                $path = $request->file('thumbnail')->store('speakers', 'public');
                $validated['thumbnail'] = $path;
            }

            $updated = $speaker->update($validated);

            if($updated) {
                Toaster::success('Speaker updated successfully');
                return redirect()
                    ->route('admin.speakers')
                    ->with('success', 'Speaker updated successfully');
            }
        } catch (\Exception $e) {
            Log::error('Speaker update failed: ' . $e->getMessage());
            Toaster::error('Failed to update speaker. Please try again.');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update speaker. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $speaker = Speaker::findOrFail($id);
            
            if ($speaker->thumbnail) {
                Storage::disk('public')->delete($speaker->thumbnail);
            }
            
            $speaker->delete();
            
            Toaster::success('Speaker deleted successfully');
            return redirect()->route('admin.speakers');
        } catch (\Exception $e) {
            Log::error('Speaker deletion failed: ' . $e->getMessage());
            Toaster::error('Failed to delete speaker');
            return redirect()->back();
        }
    }
}
