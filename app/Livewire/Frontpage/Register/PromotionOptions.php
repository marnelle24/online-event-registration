<?php

namespace App\Livewire\Frontpage\Register;

use App\Models\Programme;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class PromotionOptions extends Component
{
    public Programme $programme;
    public Collection $activePromotions;
    public string $defaultRegisterUrl;
    public array $promotionOptions = [];

    public function mount(Programme $programme): void
    {
        $this->programme = $programme;
        $this->defaultRegisterUrl = route('programme.register', $this->programme->programmeCode);

        $now = now();

        $this->activePromotions = $this->programme->promotions
            ->filter(function ($promotion) use ($now) {
                if (!$promotion->isActive) {
                    return false;
                }

                if ($promotion->startDate && $promotion->startDate->gt($now)) {
                    return false;
                }

                if ($promotion->endDate && $promotion->endDate->lt($now)) {
                    return false;
                }

                return true;
            })
            ->sortBy(function ($promotion) {
                return $promotion->arrangement ?? PHP_INT_MAX;
            })
            ->values();

        $this->promotionOptions = $this->activePromotions
            ->map(function ($promotion) {
                $parameter = Str::slug($promotion->title, ' ');

                return [
                    'id' => $promotion->id,
                    'title' => $promotion->title,
                    'description' => $promotion->description,
                    'price' => $promotion->price,
                    'parameter' => $parameter,
                    'url' => $this->defaultRegisterUrl . '?' . http_build_query(['promotion' => $parameter]),
                ];
            })
            ->all();
    }

    public function render()
    {
        return view('livewire.frontpage.register.promotion-options');
    }
}

