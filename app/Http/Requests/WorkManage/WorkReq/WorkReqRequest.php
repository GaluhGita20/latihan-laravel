<?php

namespace App\Http\Requests\WorkManage\WorkReq;

use App\Http\Requests\FormRequest;

class WorkReqRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        
        $rules = [
            'no_request' => 'required|string|max:255|unique:trans_work_req,no_request,'.$id,
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:25500',
            'aset_id' => 'required',
            'location_id' => 'required',
            'sub_location_id' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'no_request' => 'ID Work Request',
            'title' => 'Judul',
            'description' => 'Deskripsi',
            'aset_id' => 'Aset',
            'location_id' => 'Lokasi',
            'sub_location_id' => 'Sub Lokasi',
        ];

        return $attributes;
    }
}