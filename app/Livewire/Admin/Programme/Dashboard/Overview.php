<?php

namespace App\Livewire\Admin\Programme\Dashboard;

use App\Models\Programme;
use Illuminate\View\View;
use Livewire\Component;

class Overview extends Component
{
    public Programme $programme;

    public function mount(int $programmeId): void
    {
        $this->programme = Programme::withoutGlobalScopes()->findOrFail($programmeId);
    }

    public function render(): View
    {
        return view('livewire.admin.programme.dashboard.overview');
    }
}

