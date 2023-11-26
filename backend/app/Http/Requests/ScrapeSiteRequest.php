<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScrapeSiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'site_id' => 'required|integer',
            'url' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'site_id.required' => 'サイトIDは必須です。',
            'site_id.integer' => 'サイトIDには整数を入力してください。',
            'url.required' => 'URLは必須です。',
            'url.url' => 'URLはURLの形式で入力してください。',
        ];
    }
}
