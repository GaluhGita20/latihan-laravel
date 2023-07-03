<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class FailureCodeRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'aset_id' => 'required',
            'tipe_aset' => 'required',
            'name'        => 'required|string|max:225|unique:ref_failure_code,name,'.$id,
            'desc'        => 'max:225',
        ];

        return $rules;
    }
}
