<?php

namespace App\Http\Requests\Master\Pendidikan;

use App\Http\Requests\FormRequest;

class PendidikanRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_pendidikan,name,'.$id,
        ];

        return $rules;
    }
}
