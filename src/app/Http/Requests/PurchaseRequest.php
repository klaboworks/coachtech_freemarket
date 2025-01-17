<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            "payment_id" => "required",
            "postal_code" => "required",
            'address1' => 'required',
            'address2' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            "payment_id.required" => "支払方法を選択してください",
            "postal_code.required" => "配送先を入力してください",
            'address1.required' => '住所を入力してください',
            'address2.required' => '建物名を入力してください',
        ];
    }
}
