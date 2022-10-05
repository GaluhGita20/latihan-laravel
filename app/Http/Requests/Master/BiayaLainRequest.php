<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class BiayaLainRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_biaya_lain,name,'.$id,
        ];

        return $rules;
    }
}
