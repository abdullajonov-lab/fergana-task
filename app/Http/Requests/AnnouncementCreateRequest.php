<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnnouncementCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "description" => "required|string",
            "price" => "required|numeric",
            "location" => "required|string",
            "category_id" => "required|integer|exists:categories,id",
            "attachment" => "required|array",
            "attachment.*" => "file|mimes:jpg,jpeg,png,pdf|max:4096",
        ];
    }
}
