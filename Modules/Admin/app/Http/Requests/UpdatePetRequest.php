<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:pet_categories,id',
            'subcategory_id' => 'required|exists:pet_subcategories,id',
            'breed_id' => 'required|exists:pet_breeds,id',
            'birthday' => 'required|date|before:today',
            'weight' => 'required|numeric|min:0',
            'sex' => 'required|in:male,female',
            'current_medications' => 'nullable|string',
            'medication_allergies' => 'nullable|string',
            'health_conditions' => 'nullable|string',
            'special_notes' => 'nullable|string',
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
