<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ministry;
use App\Models\Programme;
use App\Models\EditorUpload;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgrammeRequest;
use App\Http\Requests\UpdateProgrammeRequest;

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
        $categories = Category::pluck('name', 'id');
        return view('admin.programme.create', compact(['categories', 'ministries']));
    }

    public function store(StoreProgrammeRequest $request)
    {
        $validated = $request->validated();
        
        $validated['private_only'] = $request->has('private_only') ? 1 : 0;
        $validated['searchable'] = $request->has('searchable') ? 1 : 0;
        $validated['publishable'] = $request->has('publishable') ? 1 : 0;
        $validated['settings'] = $this->programmeSettings($request);

        $programme = Programme::create($validated);
        $programme->categories()->sync($validated['categories'] ?? []);

        if($request->has('thumb'))
            $programme->addMediaFromRequest('thumb')->toMediaCollection('thumbnail');

        if($request->has('a3_poster'))
            $programme->addMediaFromRequest('a3_poster')->toMediaCollection('banner');

        return redirect()
            ->route('admin.programmes.show', $programme->programmeCode)
            ->with('success', 'Programme created successfully.');
    }

    public function edit($id)
    {
        $categories = Category::pluck('name', 'id');
        $programme = Programme::whereId($id)
            ->with('categories')
            ->with('ministry')
            ->first();

        if(isset($programme->settings))
        {
            $programme['onlineHybrid'] = $this->settingsData(json_decode($programme->settings, true), 'onlineHybrid');
            $programme['onlineDetails'] = $this->settingsData(json_decode($programme->settings, true), 'onlineDetails');
        }
        
        $programme['thumbnail'] = $programme->getFirstMediaUrl('thumbnail');
        $programme['banner'] = $programme->getFirstMediaUrl('banner');

        return view('admin.programme.edit', compact(['programme', 'categories']));
        
    }

    // convert additional data into json forwat then cnovert to string and store in the settings field
    public function programmeSettings($request)
    {
        $settings = [];
        $settings['onlineHybrid'] = $request->has('isOnline') ? true : false;
        $settings['onlineDetails'] = ($request->has('isOnline') && $request->has('onlineDetails')) ?  $request->get('onlineDetails') : null;
        return json_encode($settings);
    }

    // convert the string array to array variables
    public function settingsData($settingsData, $key)
    {

        return (!is_null($settingsData) && array_key_exists($key, $settingsData)) ? $settingsData[$key] : NULL;
    }

    public function show($programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)->with('speakers')->first();

        $programme['thumbnail'] = $programme->getFirstMediaUrl('thumbnail');
        $programme['banner'] = $programme->getFirstMediaUrl('banner');

        $programme['programmeLocation'] = $this->programmeLocation($programme);
        $programme['programmeDates'] = $this->programmeDates($programme);
        $programme['programmeTimes'] = $this->programmeTimes($programme);
        $programme['programmePrice'] = $this->programmePrice($programme);
        
        return view('admin.programme.show', compact('programme'));
    }

    public function update($id, UpdateProgrammeRequest $request)
    {
        $validated = $request->validated();
        
        $programme = Programme::find($id);
        
        $programme->update($validated);

        $programme->categories()->sync($validated['categories'] ?? []);

        if($request->has('thumb'))
        {
            $programme->clearMediaCollection('thumbnail');
            $programme->addMediaFromRequest('thumb')->toMediaCollection('thumbnail');
        }

        if($request->has('a3_poster'))
        {
            $programme->clearMediaCollection('banner');
            $programme->addMediaFromRequest('a3_poster')->toMediaCollection('banner');
        }

        return redirect()->route('admin.programmes.show', $programme->programmeCode);
    }


    // Proccess the date formatting
    public function programmeDates($programme)
    {
        $date = '';

        if(!empty($programme->customDate))
            return $programme->customDate;
        else
        {
            $date = $programme->endDate ? \Carbon\Carbon::parse($programme->startDate)->format('M j') : \Carbon\Carbon::parse($programme->startDate)->format('F j ,Y');
            $date .= $programme->endDate ? '-' : '';
            $date .= $programme->endDate ? \Carbon\Carbon::parse($programme->endDate)->format('j, Y') : '';
        }
        return $date;
    }

    // Process the schedule time formatting
    public function programmeTimes($programme)
    {
        $time = '';
        $time = \Carbon\Carbon::parse($programme->startTime)->format('g:i A');
        $time .= $programme->endTime ? '-' : '';
        $time .= $programme->endTime ? \Carbon\Carbon::parse($programme->endTime)->format('g:i A') : '';
        return $time;
    }
    
    // Process programme address & location
    public function programmeLocation($programme)
    {
        $location = '';
        $location = $programme->address ? $programme->address : '';
        $location .= $programme->city ? ' ,'.$programme->city : '';
        $location .= $programme->postalCode ? ' '.$programme->postalCode : '';
        return $location;
    }

    // process the programme price and currency
    public function programmePrice($programme)
    {
        $currency = 'SGD';
        return $programme->price > 0 ? $currency.' '.number_format($programme->price, 2) : 'Free';
    }


    public function destroy()
    {
        return view('admin.programme.destroy');
    }
    
}
