<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name' => 'required',
            'item_description' => 'required|max:255',
            'item_image' => 'required|mimes:jpeg,jpg,png',
            'categories' => 'required',
            'condition_id' => 'required',
            'price' => 'required|integer|min:0|max:1000000',
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'item_description.required' => '商品の説明を入力してください',
            'item_description.max' => '商品の説明は255文字以内で入力してください',
            'item_image.required' => '商品の画像を選択してください',
            'item_image.mimes' => 'アップロードできる画像はjpeg形式かpng形式のみです',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'price.required' => '商品の金額を設定してください',
            'price.integer' => '商品の金額を数値で設定してください',
            'price.min' => '商品の金額を0円以上で設定してください',
            'price.max' => '100万円以上は出品できません',
        ];
    }
}
