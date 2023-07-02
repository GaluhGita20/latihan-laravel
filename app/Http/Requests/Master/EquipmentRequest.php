<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_equipment,name,'.$id,
            'plant_id'        => 'required',
            'system_id'        => 'required',
        ];

        return $rules;
    }
}
