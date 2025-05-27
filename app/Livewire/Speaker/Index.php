<?php

namespace App\Livewire\Speaker;

use App\Models\Speaker;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public ?string $search;
    public $programmeSpeakers;

    public function render()
    {
        $speakers = [];

        if($this->programmeSpeakers)
            $spkrs = $this->programmeSpeakers;
        else
        {
            $spkrs = Speaker::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', "%{$this->search}%");
                    $query->orWhere('email', 'like', "%{$this->search}%");
                    $query->orWhere('title', 'like', "%{$this->search}%");
                })
                ->latest('created_at')
                ->get();
        }

        $speakers = $spkrs;

        return view('livewire.speaker.index', [
            'speakers' => $speakers,
        ]);
    }
}
