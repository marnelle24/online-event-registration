<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgrammeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'programmeCode' => 'required|unique:programmes,programmeCode',
            'type' => 'required|in:course,event',
            'excerpt' => 'nullable|string|max:300',
            'description' => 'nullable',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after:startDate',
            'startTime' => 'nullable',
            'endTime' => 'nullable',
            'customDate' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'postalCode' => 'nullable',
            'country' => 'nullable',
            'latLong' => 'nullable',
            'price' => 'required|numeric|min:0|max:100',
            'adminFee' => 'nullable|numeric|min:0|max:100',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'a3_poster' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'contactNumber' => 'nullable',
            'contactPerson' => 'nullable',
            'contactEmail' => 'nullable|email',
            'limit' => 'nullable|numeric|min:0|max:100',
            'settings' => 'nullable|json',
            'extraFields' => 'nullable|json',
            'searchable' => 'nullable|boolean',
            'publishable' => 'nullable|boolean',
            'private_only' => 'nullable|boolean',
            'externalUrl' => 'nullable|string',
            'status' => 'nullable|in:draft,published,archive',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title must not be empty',
            'programmeCode.required' => 'Programme Code must not be empty',
            'programmeCode.unique' => 'Programme Code inputted already exists.',
            'type.required' => 'Programme type must not be empty.',
            'startDate.required' => 'Start Date must not be empty.',
            'endDate.required' => 'End Date must not be empty.',
            'endDate.after' => 'End Date must not be lesser than starting date.',
            'price.required' => 'Price must not be empty. Set it to 0 if its free programme.',
        ];
    }
}
