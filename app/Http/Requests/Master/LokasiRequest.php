<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class LokasiRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'struct_id' => 'required|exists:sys_structs,id',
            'name'        => 'required|string|max:255|unique:ref_location,name,'.$id,
        ];

        return $rules;
    }
}
