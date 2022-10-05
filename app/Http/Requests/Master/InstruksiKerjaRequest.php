<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class InstruksiKerjaRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'struct_id' => 'required|exist:sys_struct,id',
            'name'        => 'required|string|max:255|unique:ref_instruksi_kerja,name,'.$id,
        ];

        return $rules;
    }
}
