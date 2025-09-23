<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use Masmerise\Toaster\Toaster;

class AllPromotion extends Component
{
    public $programmeId;
    public $promotions;

    protected $listeners = [
        'newAddedPromotion' => 'refreshPromotions',
        'updatedPromotion' => 'refreshPromotions'
    ];

    public function mount()
    {
        $this->promotions = Promotion::where('programme_id', $this->programmeId)
            ->orderBy('startDate', 'asc')
            ->get();
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::find($id);
        $promotion->delete();
        Toaster::success('Promotion deleted successfully!');
        \Log::info('Promotion deleted successfully in programme id: ' . $this->programmeId);
        $this->refreshPromotions();
    }

    public function refreshPromotions()
    {
        $this->promotions = Promotion::where('programme_id', $this->programmeId)
            ->orderBy('startDate', 'asc')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.promotion.all-promotion');
    }
}
