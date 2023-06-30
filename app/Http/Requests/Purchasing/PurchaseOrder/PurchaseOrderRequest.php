<?php

namespace App\Http\Requests\Purchasing\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        
        $rules = [
            'id_purchase_order' => 'required|unique:trans_purchase_order,id_purchase_order,' . $id,
            'tgl_purchase_order' => 'required',
            'tgl_kirim' => 'required',
            'vendor_id' => 'required',
        ];
        return $rules;
    }
}
