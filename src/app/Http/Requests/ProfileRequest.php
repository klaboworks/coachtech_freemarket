<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'avatar' => 'image|mimes:jpeg,jpg,png',
        ];
    }

    public function messages(): array
    {
        return [
            'avater.image' => '入力できるのは画像のみです',
            'avater.mimes' => '入力できるのは画像jpeg形式かpng形式のみです',
        ];
    }
}
