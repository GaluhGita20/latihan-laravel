<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class AsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'code'        => 'required|string|max:20|unique:ref_aset,name,'.$id,
            'name'        => 'required|string|max:255|unique:ref_aset,name,'.$id,
        ];

        return $rules;
    }
}
