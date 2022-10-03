<?php

namespace App\Http\Requests\Example\Crud;

use App\Http\Requests\FormRequest;

class CrudRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        
        $rules = [
            'year' => 'required',
            'date' => 'required',
            'range_start' => 'required',
            'input' => 'required|string|max:255',
            'textarea' => 'required|string|max:25500',
            'option' => 'required',
            'details' => 'required|array',
            'details.*.example_id' => 'required|distinct',
            'details.*.position_id' => 'required',
            'details.*.user_id' => 'required',
            'details.*.description' => 'required|string|max:25500',
        ];

        if ($this->range_start) {
            $rules += [
                'range_end' => 'required',
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'year' => 'Tahun',
            'date' => 'Tanggal',
            'range_start' => 'Mulai',
            'range_end' => 'Selesai',
            'input' => 'Input',
            'textarea' => 'Textarea',
            'option' => 'Option',
            'details' => 'Detail',
            'details.*.example_id' => 'Example',
            'details.*.position_id' => 'Jabatan',
            'details.*.user_id' => 'User',
        ];

        return $attributes;
    }
}