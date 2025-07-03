<?php

namespace App\Livewire\Promocode;

use Livewire\Component;
use App\Models\Programme;
use App\Models\Promocode;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $programmeId;

    protected $listeners = [
        'newAddedPromocode' => 'render',
    ];

    public function mount($programmeId)
    {
        $this->programmeId = $programmeId ?? '';
    }

    public function removePromocode($promocode_id)
    {
        $promotion = Promocode::find($promocode_id);
        if(!$promotion)
            Toaster::error('Something wrong deleting promo code. Please contact administrator.');
        
        $promotion->delete($promocode_id);
        Toaster::success('Promo code removed successfully.');
        $this->render();

    }

    public function render()
    {
        $promocodes = Promocode::where('programme_id', $this->programmeId)->orderBy('startDate')->get();
        return view('livewire.promocode.index', [
            'promocodes' => $promocodes
        ]);
    }
}
