<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class InstruksiKerjaRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'aset_id'       => 'required',
            'part_id'       => 'required',
            'assemblies_id' => 'required',
            'name'          => 'required|string|max:255|unique:ref_instruksi_kerja,name,' . $id,
        ];

        return $rules;
    }
}
