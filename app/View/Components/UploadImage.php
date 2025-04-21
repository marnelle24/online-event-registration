<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UploadImage extends Component
{
    public $name;
    public $label;
    public $emptyLabel;
    /**
     * Create a new component instance.
     */
    public function __construct($label='Upload Image', $emptyLabel = 'Image', $name = 'photo')
    {
        // $this->classes = $classes;
        $this->label = $label;
        $this->emptyLabel = $emptyLabel;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.upload-image');
    }
}
