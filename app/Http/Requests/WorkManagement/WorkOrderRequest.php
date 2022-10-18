<?php

namespace App\Http\Requests\WorkManagement;

use App\Models\WorkManagement\WorkOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleUnique = 'unique:work_work_order,work_order_id';

        if($this->input('created_at')){

            $checkid = WorkOrder::where('id', $this->input('id'))->first();

            if($checkid['work_order_id'] == $this->input('work_order_id')){
                $ruleUnique = Rule::unique('work_work_order')->ignore($this->input('work_order_id'), 'work_order_id');
            } 
        } 

        return [
            "work_order_id" => ['required', 'string', 'max:50', $ruleUnique],
            "maintenance_type_id" => 'required',
            "priority_id" => 'required',
            "asset_id" => 'required',
            "done_target_date" => 'required',
            "user_id" => 'required',
            "description" => 'nullable',
            "estimation_cost" => 'required|regex:/^[0-9\.]+$/',
            "request_by" => 'required|string',
            "attachment" => 'nullable',
            "instruction" => 'nullable',
            "other_costs" => 'nullable'
        ];
    }
}
