<?php

namespace App\View\Components;

use App\Services\CountryService;
use Illuminate\View\Component;

class CountrySelect extends Component
{
    public $countries;
    public $selected;
    public $name;
    public $id;
    public $class;
    public $required;
    public $placeholder;
    public $withFlags;
    public $withCode;
    public $withPhoneCode;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $selected = '',
        $name = 'country',
        $id = 'country',
        $class = '',
        $required = false,
        $placeholder = 'Select Country',
        $withFlags = true,
        $withCode = false,
        $withPhoneCode = false
    ) {
        $countryService = new CountryService();
        
        if ($withFlags) {
            $this->countries = $countryService->getCountriesWithFlags($withCode, $withPhoneCode);
        } else {
            $this->countries = $countryService->getCountriesWithCommonFirst(false, $withCode, $withPhoneCode);
        }
        
        $this->selected = $selected;
        $this->name = $name;
        $this->id = $id;
        $this->class = $class;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->withFlags = $withFlags;
        $this->withCode = $withCode;
        $this->withPhoneCode = $withPhoneCode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.country-select');
    }
}
