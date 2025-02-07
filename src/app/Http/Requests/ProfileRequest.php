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
            'name' => 'required',
            'avatar' => 'image|mimes:jpeg,jpg,png',
            'postal_code' => 'regex:/^\d{3}-\d{4}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'avatar.image' => '画像を選択してください',
            'avatar.mimes' => 'アップロードできる画像はjpeg形式かpng形式のみです',
            'postal_code.regex' => '郵便番号はハイフン(-)入りの8文字で入力してください',
        ];
    }
}
