<?php

namespace App\View\Components\Programme;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{

    public $programme;
    /**
     * Create a new component instance.
     */
    public function __construct($programme)
    {
        $this->programme = $programme;
    }

    // Proccess the date formatting
    public function programmeDates()
    {
        $date = '';

        if(!empty($this->programme->customDate))
            return $this->programme->customDate;
        else
        {
            $date = $this->programme->endDate ? \Carbon\Carbon::parse($this->programme->startDate)->format('M j') : \Carbon\Carbon::parse($this->programme->startDate)->format('F j ,Y');
            $date .= $this->programme->endDate ? '-' : '';
            $date .= $this->programme->endDate ? \Carbon\Carbon::parse($this->programme->endDate)->format('j, Y') : '';
        }
        return $date;
    }

    // Process the schedule time formatting
    public function programmeTimes()
    {
        $time = '';
        $time = \Carbon\Carbon::parse($this->programme->startTime)->format('g:i A');
        $time .= $this->programme->endTime ? '-' : '';
        $time .= $this->programme->endTime ? \Carbon\Carbon::parse($this->programme->endTime)->format('g:i A') : '';
        return $time;
    }
    
    // Process programme address & location
    public function programmeLocation()
    {
        $location = '';
        $location = $this->programme->address ? $this->programme->address : '';
        $location .= $this->programme->city ? ' ,'.$this->programme->city : '';
        $location .= $this->programme->postalCode ? ' '.$this->programme->postalCode : '';
        return $location;
    }

    // process the programme price and currency
    public function programmePrice()
    {
        $currency = 'SGD';
        return $this->programme->price > 0 ? $currency.' '.number_format($this->programme->price, 2) : 'Free';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.programme.card');
    }
}
