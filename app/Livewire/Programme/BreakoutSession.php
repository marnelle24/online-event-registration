<?php

namespace App\Livewire\Programme;

use Livewire\Component;
use App\Models\Breakout;
use Masmerise\Toaster\Toaster;

class BreakoutSession extends Component
{
    public $programmeId;
    public $breakouts;
    
    public function mount()
    {
        $this->breakouts = Breakout::where('programme_id', $this->programmeId)
            ->where('isActive', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function deleteBreakout($id)
    {
        $breakout = Breakout::find($id);
        $breakout->isActive = false;
        $breakout->save();
        Toaster::success('Breakout session deleted successfully!');
        \Log::info('Breakout session deleted successfully in programme id: ' . $this->programmeId);
        
        // update the list of breakouts
        // $this->breakouts = Breakout::where('programme_id', $this->programmeId)
        //     ->where('isActive', true)
        //     ->orderBy('order', 'asc')
        //     ->get();

        $this->mount();
    }
    

    public function render()
    {
        return view('livewire.programme.breakout-session');
    }
}
