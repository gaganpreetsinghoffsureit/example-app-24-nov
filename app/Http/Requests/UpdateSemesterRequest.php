<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateSemesterRequest extends FormRequest
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
            "name" => [
                "required", "min:3", "max:255", "string",
                Rule::unique((new Semester())->getTable(), 'name')->ignore($this->route('semester'))
            ],
            "course_id" => ["required", "exists:" . (new Course())->getTable() . ",id"],

        ];
    }
}
