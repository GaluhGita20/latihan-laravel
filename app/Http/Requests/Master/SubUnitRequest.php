<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class SubUnitRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_sub_unit,name,'.$id,
            'plant_id'        => 'required',
            'system_id'        => 'required',
            'equipment_id'        => 'required',
        ];

        return $rules;
    }
}
