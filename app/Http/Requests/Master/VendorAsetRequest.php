<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class VendorAsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'city_id' => 'required',
            'code'        => 'required|string|max:12|unique:ref_vendor_aset,code,'.$id,
            'name'        => 'required|string|max:255|unique:ref_vendor_aset,name,'.$id,
            'alamat'        => 'required|string||unique:ref_vendor_aset,alamat,'.$id,
            'kodepos'        => 'required|string|max:255|unique:ref_vendor_aset,kodepos,'.$id,
            'telepon'        => 'required|string|max:255|unique:ref_vendor_aset,telepon,'.$id,
            'email'        => 'required|string|max:255|unique:ref_vendor_aset,email,'.$id,
            'pic'        => 'required|string|max:255|unique:ref_vendor_aset,pic,'.$id,
            'website'        => 'required|string|max:255|unique:ref_vendor_aset,website,'.$id,
        ];

        return $rules;
    }
}
