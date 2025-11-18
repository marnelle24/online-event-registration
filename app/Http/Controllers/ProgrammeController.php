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
    public function show($programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)->firstOrFail();
        $programme['programme'] = $programme->getFirstMediaUrl('programme');
        $programme['banner'] = $programme->getFirstMediaUrl('banner');

        return view('admin.programme.show', compact('programme'));
    }

    public function publicShow($programmeCode)
    {
        $programme = Programme::where('programmeCode', $programmeCode)
            ->with(['speakers', 'categories', 'ministry', 'promotions', 'breakouts.speaker'])
            ->where('publishable', true)
            ->where('searchable', true)
            ->where('status', 'published')
            ->first();

        if (!$programme) 
        {
            abort(404, 'Programme not found or not available for public viewing.');
        }

        return view('pages.programme-details', compact('programme'));
    }

    public function softDelete($id)
    {
        $programme = Programme::find($id);
        $programme->soft_delete = true;
        $programme->save();
        
        // log the action to the log file
        \Log::info('Programme with programme code ' . $programme->programmeCode . ' has been soft deleted by user_id: ' . auth()->user()->id);

        return redirect()->route('admin.programmes')->with('success', 'Programme deleted successfully.');
    }
    
}
