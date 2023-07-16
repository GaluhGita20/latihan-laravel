<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class AsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'struktur_aset'        => 'required',
            'id_aset'        => 'required',
            'name'        => 'required|string|max:255|unique:ref_asets,name,'.$id,
            'harga_per_unit'     => 'required',
            
        ];

        return $rules;
    }
}
