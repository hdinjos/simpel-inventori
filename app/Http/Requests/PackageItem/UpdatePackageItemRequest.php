<?php

namespace App\Http\Requests\PackageItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageItemRequest extends FormRequest
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
            'quantity' => 'required|integer',
            'product_id' => 'required|string',
        ];
    }
}
