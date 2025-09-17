<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'gender'            => 'required|in:male,female',
            'specialization_id' => ['required', 'exists:specializations,id'],
        ];

        // إذا طالب
        if ($this->user()->hasRole('student')) {
            $rules = array_merge($rules, [
                'major'  => ['nullable', 'string', 'max:255'],
                'points' => ['nullable', 'integer', 'min:0'],
                'year'   => ['nullable', 'integer', 'min:1'],
                'bio'    => ['nullable', 'string', 'max:1000'],
            ]);
        }

        // إذا مشرف
        if ($this->user()->hasRole('supervisor')) {
            $rules = array_merge($rules, [
                'department_id' => ['required', 'exists:departments,id'],
            ]);
        }

        return $rules;
    }
}
