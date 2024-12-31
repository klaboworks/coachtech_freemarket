<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends ProfileRequest
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
            'postal_code' => 'required|size:8',
            'address1' => 'required',
            'address2' => 'required',
        ] + parent::rules();
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.size' => '郵便番号はハイフン(-)入りの8文字で入力してください',
            'address1.required' => '住所を入力してください',
            'address2.required' => '建物名を入力してください',
        ] + parent::messages();
    }
}
