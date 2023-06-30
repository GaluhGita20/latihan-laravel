<?php

namespace App\Http\Requests\Purchasing\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderDetailRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'barang_id' => 'required',
            'jumlah' => 'required',
            'harga_per_unit' => 'required',
            'total_harga' => 'required',
        ];
        return $rules;
    }
}
