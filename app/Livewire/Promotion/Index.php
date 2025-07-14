<?php

namespace App\Livewire\Promotion;

use Livewire\Component;
use App\Models\Promotion;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $programmeId;

    protected $listeners = [
        'newAddedPromotion' => 'render',
        'updatedPromotion' => 'render',
    ];

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId ?? '';
    }

    public function removePromotion($promotion_id)
    {
        $promotion = Promotion::find($promotion_id);
        if(!$promotion)
            Toaster::error('Something wrong deleting promotion. Please contact administrator.');
        
        $promotion->delete($promotion_id);
        Toaster::success('Promotion removed successfully.');

    }

    public function render()
    {
        $promotions = Promotion::where('programme_id', $this->programmeId)->orderBy('arrangement', 'ASC')->get();
        return view('livewire.promotion.index', [
            'promotions' => $promotions
        ]);
    }
}
