<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class ItemPemeliharaanRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_item_pemeliharaan,name,'.$id,
            'tipe_pemeliharaan_id'        => 'required',
        ];

        return $rules;
    }
}
