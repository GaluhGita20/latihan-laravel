<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class RootRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'    => 'required|string|max:255|unique:sys_structs,name,'.$id.',id,level,root',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:65500',
        ];

        return $rules;
    }
}
