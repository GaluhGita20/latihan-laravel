<?php

namespace App\Http\Requests\Purchasing\GoodReceipt;

use Illuminate\Foundation\Http\FormRequest;

class GoodReceiptRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'tgl_penerimaan' => 'required',
        ];
        return $rules;
    }
}
