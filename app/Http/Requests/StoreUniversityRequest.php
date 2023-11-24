<?php

namespace App\Http\Requests;

use App\Models\University;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "min:3", "max:255", "string", "unique:".(new University())->getTable()],
            "address" => ["required", "min:3", "max:255", "string"],
            "zip_code" => ["required", "min:3", "max:255", "string"],
            "city" => ["required", "min:3", "max:255", "string"],
            "state" => ["required", "min:3", "max:255", "string"],
            "country" => ["required", "min:3", "max:255", "string"],
        ];
    }
}
