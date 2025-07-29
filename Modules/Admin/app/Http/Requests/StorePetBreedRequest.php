<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetBreedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'pet_subcategory_id' => 'required|exists:pet_subcategories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'typical_weight_min' => 'required|numeric|min:0',
            'typical_weight_max' => 'required|numeric|min:0|gte:typical_weight_min',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
