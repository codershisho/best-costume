<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'scrape_site_id' => 'required|integer',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'description' => '',
            'note' => '',
        ];
    }

    public function messages()
    {
        return [
            'scrape_site_id.required' => 'サイトIDは必須です。',
            'scrape_site_id.integer' => 'サイトIDには整数を入力してください。',
            'name.required' => 'URLは必須です。',
            'name.string' => 'URLはURLの形式で入力してください。',
            'category_id.required' => 'カテゴリーは必須です。',
            'category_id.integer' => 'カテゴリーは整数を入力してください。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格には整数を入力してください。',
        ];
    }
}
