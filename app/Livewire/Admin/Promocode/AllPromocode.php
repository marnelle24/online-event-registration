<?php

namespace App\Livewire\Admin\Promocode;

use Livewire\Component;
use App\Models\Promocode;
use Masmerise\Toaster\Toaster;

class AllPromocode extends Component
{
    public $programmeId;
    public $promocodes;

    protected $listeners = [
        'newAddedPromocode' => 'refreshPromocodes',
        'updatedPromocode' => 'refreshPromocodes',
    ];

    public function callEditPromocodeModal($promocodeId)
    {
        $this->dispatch('callEditPromocodeModal', $promocodeId)->to('admin.promocode.edit-promocode');
    }

    public function mount()
    {
        $this->promocodes = Promocode::where('programme_id', $this->programmeId)
            ->orderBy('startDate', 'asc')
            ->get();
    }

    public function removePromocode($promocode_id)
    {
        $promotion = Promocode::find($promocode_id);
        if(!$promotion)
            Toaster::error('Something wrong deleting promo code. Please contact administrator.');
        
        $promotion->delete($promocode_id);
        Toaster::success('Promo code removed successfully.');
        $this->refreshPromocodes();
    }

    public function refreshPromocodes()
    {
        $this->promocodes = Promocode::where('programme_id', $this->programmeId)
            ->orderBy('startDate', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.promocode.all-promocode');
    }
}
