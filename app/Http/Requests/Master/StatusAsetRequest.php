<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class StatusAsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_status_aset,name,'.$id,
        ];

        return $rules;
    }
}
