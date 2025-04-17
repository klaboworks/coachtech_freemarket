<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
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
            'deal_message' => 'required|max:400',
            'additional_image' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function messages(): array
    {
        return [
            'deal_message.required' => '本文を入力してください',
            'deal_message.max' => '本文は400文字以内で入力してください',
            'additional_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
