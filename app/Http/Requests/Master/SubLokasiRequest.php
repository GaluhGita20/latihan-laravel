<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class SubLokasiRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_sub_lokasi,name,'.$id,
        ];

        return $rules;
    }
}