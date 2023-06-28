<?php

namespace App\Http\Requests\RencanaPemeliharaan\Jadwal;

use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'year'  => 'required',
            'unit_kerja_id'  => 'required',
            'aset_id' => 'required',
            'location_id' => 'required',
            'sub_location_id' => 'required',
            'uraian' => 'required|string|max:255',
        ];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'year' => 'Tahun',
            'unit_kerja_id' => 'Unit Kerja',
            'location_id' => 'Lokasi',
            'sub_location_id' => 'Sub Lokasi',
            'aset_id' => 'Aset',
            'uraian' => 'Uraian',
        ];

        return $attributes;
    }
}
