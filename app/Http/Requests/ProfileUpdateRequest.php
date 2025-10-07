<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
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
            'gender'            => ['required', 'in:male,female'],
            'specialization_id' => ['required', 'exists:specializations,id'],
        ];

        // إذا طالب
        if ($this->user()->hasRole('student')) {
            $rules = array_merge($rules, [
                'year'          => ['required', 'integer', 'min:1'],
                'bio'           => ['nullable', 'string', 'max:1000'],
                // 'supervisor_id' => ['required', 'exists:supervisors,id'], // ✅ أضف هذا
            ]);

        }

        // إذا مشرف
        if ($this->user()->hasRole('supervisor')) {
            $rules = array_merge($rules, [
                // 'department_id' => ['required', 'exists:departments,id'],
            ]);
        }

        return $rules;
    }
}
