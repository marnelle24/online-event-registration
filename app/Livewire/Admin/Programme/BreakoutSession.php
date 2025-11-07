<?php

namespace App\Livewire\Admin\Programme;

use Livewire\Component;
use App\Models\Breakout;
use Masmerise\Toaster\Toaster;

class BreakoutSession extends Component
{
    public $programmeId;
    public $breakouts;

    protected $listeners = [
        'newAddedBreakout' => 'refreshBreakouts',
        'breakoutUpdated' => 'refreshBreakouts'
    ];
    
    public function mount()
    {
        $this->breakouts = Breakout::where('programme_id', $this->programmeId)
            ->where('isActive', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function refreshBreakouts()
    {
        $this->breakouts = Breakout::where('programme_id', $this->programmeId)
            ->where('isActive', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function deleteBreakout($id)
    {
        $breakout = Breakout::find($id);
        $breakout->delete();
        Toaster::success('Breakout session deleted successfully!');
        \Log::info('Breakout session deleted successfully in programme id: ' . $this->programmeId);
        $this->refreshBreakouts();
    }
    

    public function render()
    {
        return view('livewire.admin.programme.breakout-session');
    }
}
