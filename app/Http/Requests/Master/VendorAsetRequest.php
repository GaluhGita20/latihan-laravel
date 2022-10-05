<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class VendorAsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'city_id'       => 'required',
            'code'          => 'required|string|max:12|unique:ref_vendor_aset,code,'.$id,
            'name'          => 'required|string|max:255|unique:ref_vendor_aset,name,'.$id,
            'alamat'        => 'required|string',
            'kodepos'       => 'required|string',
            'telepon'       => 'required|string',
            'email'         => 'required|string',
            'pic'           => 'required|string',
            'website'       => 'required|string',
        ];

        return $rules;
    }
}
