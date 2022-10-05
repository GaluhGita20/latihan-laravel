<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class KondisiAsetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_kondisi_aset,name,'.$id,
        ];

        return $rules;
    }
}
