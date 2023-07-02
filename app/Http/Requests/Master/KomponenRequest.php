<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class KomponenRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_komponen,name,'.$id,
            'plant_id'        => 'required',
            'system_id'        => 'required',
            'equipment_id'        => 'required',
            'sub_unit_id'        => 'required',
        ];

        return $rules;
    }
}
