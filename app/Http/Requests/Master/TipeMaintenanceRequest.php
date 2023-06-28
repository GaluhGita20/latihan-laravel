<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class TipeMaintenanceRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_tipe_maintenance,name,'.$id,
            'desc'        => 'max:225',
        ];

        return $rules;
    }
}
