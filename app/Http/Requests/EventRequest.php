<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
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
            'event_name'   => 'nullable|string|max:100',
            'event_date'   => 'nullable|date',
            'event_time' => ['nullable', function ($attribute, $value, $fail) {
                if (
                    !\DateTime::createFromFormat('H:i', $value) &&
                    !\DateTime::createFromFormat('H:i:s', $value)
                ) {
                    $fail('صيغة وقت الحدث يجب أن تكون HH:MM أو HH:MM:SS.');
                }
            }],

            'location'     => 'nullable|string|max:100',
            'attendees'    => 'nullable|string',
            'description'  => 'nullable|string',
            'attach'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'خطأ في التحقق من البيانات',
            'errors' => $validator->errors(),
        ], 422));
    }
}
