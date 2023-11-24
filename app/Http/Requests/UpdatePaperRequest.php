<?php

namespace App\Http\Requests;

use App\Models\Subject;
use App\Rules\UniqueArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePaperRequest extends FormRequest
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
            "subject_id" => ["required", "exists:" . (new Subject())->getTable() . ",id"],
            "date" => ["required", "date"],
            "images" => ["required", "array", new UniqueArray],
        ];
    }
}
