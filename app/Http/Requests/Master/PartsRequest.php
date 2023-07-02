<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class PartsRequest extends FormRequest
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
            'komponen_id'        => 'required',
        ];

        return $rules;
    }
}
