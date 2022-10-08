<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class PartsRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'code'        => 'required|string|max:20|unique:ref_parts,name,'.$id,
            'name'        => 'required|string|max:255|unique:ref_parts,name,'.$id,
            'status_aset_id'     => 'required',
            'kondisi_aset_id'     => 'required',
            'asset_type_id'     => 'required',
            'location_id'     => 'required',
            'sub_lokasi_id'     => 'required',
            // 'assemblies_id'     => 'required',
            
        ];

        return $rules;
    }
}
