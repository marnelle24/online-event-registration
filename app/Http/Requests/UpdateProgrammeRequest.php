<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProgrammeRequest extends FormRequest
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
            'programmeCode' => 'required|'.Rule::unique('programmes')->ignore($this->id),
            'type' => 'required|in:course,event',
            'excerpt' => 'nullable|string|max:300',
            'description' => 'nullable',
            'activeUntil' => 'nullable|date',
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
            'price' => 'required|numeric|min:0',
            'adminFee' => 'nullable|numeric|min:0|max:100',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:1280',
            'a3_poster' => 'nullable|image|mimes:jpeg,png,jpg|max:1280',
            'contactNumber' => 'nullable',
            'contactPerson' => 'nullable',
            'contactEmail' => 'nullable|email',
            'limit' => 'nullable|numeric|min:0',
            'settings' => 'nullable|json',
            'extraFields' => 'nullable|json',
            'externalUrl' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'private_only' => 'boolean',
            'searchable' => 'boolean',
            'publishable' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
