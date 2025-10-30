# Country Dropdown Implementation

## Overview
This implementation provides a comprehensive country dropdown solution using the `league/iso3166` package, which provides ISO 3166-1 country codes and names.

## Package Used
- **Package**: `league/iso3166`
- **Version**: ^4.3
- **Description**: A PHP library for ISO 3166-1 country codes and names

## Files Created/Modified

### 1. CountryService (`app/Services/CountryService.php`)
A service class that provides various methods for working with countries:

```php
// Get all countries with common ones first
$countries = $countryService->getCountriesWithCommonFirst();

// Get all countries (alphabetically sorted)
$countries = $countryService->getCountries();

// Get country name by alpha2 code
$name = $countryService->getCountryNameByAlpha2('SG');

// Search countries
$results = $countryService->searchCountries('sing');
```

### 2. CountrySelect Component (`app/View/Components/CountrySelect.php`)
A reusable Blade component for country dropdowns:

```blade
<x-country-select 
    :selected="$user->country"
    name="country"
    id="country"
    class="custom-class"
    :required="true"
    placeholder="Choose your country"
/>
```

### 3. Updated Programme Components
- `AddProgramme.php` - Updated to use CountryService
- `EditProgramme.php` - Updated to use CountryService
- `add-programme.blade.php` - Updated to use countries dropdown
- `edit-programme.blade.php` - Updated to use countries dropdown

## Features

### 1. Country Flags, Codes & Phone Numbers 🏳️
Each country option displays its flag emoji, country code, and phone code alongside the country name for comprehensive identification and user experience.

### 2. Common Countries First
The service prioritizes common countries (Singapore, Malaysia, Indonesia, etc.) at the top of the dropdown for better user experience.

### 3. Separator
A visual separator (`---`) is added between common countries and the rest for better organization.

### 4. Alphabetical Sorting
All countries are sorted alphabetically for easy navigation.

### 5. Multiple Formats
Support for different country code formats:
- Country names (default)
- Alpha2 codes (SG, MY, ID)
- Alpha3 codes (SGP, MYS, IDN)

### 6. Search Functionality
Built-in search capability for finding countries by name.

### 7. Flag Generation
Automatic flag emoji generation using Unicode Regional Indicator Symbols for all 251 countries.

### 8. Country Code Display
Optional display of 2-letter country codes (ISO 3166-1 alpha-2) beside the flag for technical users and better identification.

### 9. Phone Code Display
Optional display of international phone codes (ITU-T E.164) for each country, making it easy to identify calling codes.

## Usage Examples

### In Livewire Components
```php
use App\Services\CountryService;

public function countries()
{
    $countryService = new CountryService();
    return $countryService->getCountriesWithFlagsCodesAndPhone(); // With flags, codes, and phone codes
    // or
    return $countryService->getCountriesWithFlagsAndCodes(); // With flags and codes
    // or
    return $countryService->getCountriesWithFlags(); // With flags only
    // or
    return $countryService->getCountriesWithCommonFirst(); // Without flags
}

public function render()
{
    return view('livewire.your-component', [
        'countries' => $this->countries()
    ]);
}
```

### In Blade Templates
```blade
<select wire:model="country" class="form-control">
    <option value="">Select Country</option>
    @foreach($countries as $code => $name)
        @if($code === '---')
            <option disabled>──────────────</option>
        @else
            <option value="{{ $code }}">{!! $name !!}</option>
        @endif
    @endforeach
</select>
```

### Using the Blade Component
```blade
<!-- With flags, codes, and phone codes (recommended) -->
<x-country-select 
    :selected="$selectedCountry"
    name="country"
    id="country"
    class="w-full p-2 border rounded"
    :required="true"
    :withFlags="true"
    :withCode="true"
    :withPhoneCode="true"
/>

<!-- With flags and codes only -->
<x-country-select 
    :selected="$selectedCountry"
    name="country"
    id="country"
    class="w-full p-2 border rounded"
    :required="true"
    :withFlags="true"
    :withCode="true"
    :withPhoneCode="false"
/>

<!-- With flags only -->
<x-country-select 
    :selected="$selectedCountry"
    name="country"
    id="country"
    class="w-full p-2 border rounded"
    :required="true"
    :withFlags="true"
    :withCode="false"
    :withPhoneCode="false"
/>

<!-- Without flags -->
<x-country-select 
    :selected="$selectedCountry"
    name="country"
    id="country"
    class="w-full p-2 border rounded"
    :required="true"
    :withFlags="false"
    :withCode="false"
    :withPhoneCode="false"
/>
```

## Benefits

1. **Comprehensive**: Covers all 251 countries from ISO 3166-1
2. **Visual**: Country flags for better user experience and recognition
3. **Technical**: Country codes for developers and technical users
4. **Communication**: Phone codes for international calling reference
5. **User-Friendly**: Common countries appear first
6. **Reusable**: Blade component can be used anywhere
7. **Maintainable**: Centralized in CountryService
8. **Standards Compliant**: Uses official ISO 3166-1 and ITU-T E.164 data
9. **Searchable**: Built-in search functionality
10. **Flexible**: Multiple output formats supported
11. **Unicode Compatible**: Uses standard flag emojis that work across all platforms
12. **Configurable**: Toggle flags, codes, and phone codes independently

## Installation

The package is already installed via Composer:
```bash
composer require league/iso3166
```

## Future Enhancements

1. **State/City Integration**: Could be extended to include states and cities
2. **Localization**: Support for country names in different languages
3. **Caching**: Cache country data for better performance
4. **Custom Ordering**: Allow custom country ordering per application needs
