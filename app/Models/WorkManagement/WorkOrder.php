<?php

namespace App\Models\WorkManagement;

use App\Http\Controllers\AjaxController;
use App\Models\Auth\User;
use App\Models\Master\Aset;
use App\Models\Master\PrioritasAset;
use App\Models\Master\TipeMaintenance;
use App\Models\Traits\RaidModel;
use App\Models\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class WorkOrder extends Model
{
    use HasFactory, RaidModel, ResponseTrait;
    public $table = 'work_work_order';

    protected $fillable = [
        "work_order_id", "maintenance_type_id", "priority_id", "asset_id", 
        "done_target_date", "user_id", "description",
        "estimation_cost", "request_by", "attachment", 'instruction', 'other_costs',
        "status", "created_by", "updated_by", "created_at", "created_by"
    ];

    public const DRAFT = 0;
    public const COMPLETE = 1;

    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/
    public function getNominalCurrencyAttribute()
    {
        return "Rp".number_format($this->nominal,0,',','.');
    }

    public function getStatusName() {
        $status = $this->status ?? null;
        $result = '';

        switch($status) {
            case 0 :
                $result = '<span class="badge badge-warning text-white">'. $this->getStatusDescription($status) .'</span>';
                break;
            case 1 :
                $result = '<span class="badge badge-success text-white">'. $this->getStatusDescription($status) .'</span>';
                break;
            default :
                $result = '';
        }
        return $result;
    }

    public function getUserName()
    {
        $users = $this->getUser($this->user);

        return implode(", ", array_column($users, 'name'));
    }

    public function getUser($users)
    {
        $users_arr = json_decode($users, true);
        $pelaksana = array();

        foreach($users_arr as $user){
            $getPelaksana = User::has('position')->where('id', $user)->first();
            $pelaksana_arr = [
                "id" => $getPelaksana["id"],
                "name" => $getPelaksana['name'],
                "alias" => $getPelaksana['name'] . ' (' . $getPelaksana["position"]['name'] . ')'
            ];

            array_push($pelaksana, $pelaksana_arr);
        }

        return $pelaksana;
    }

    public static function getStatusDescription($statusCode)
    {
        switch ($statusCode) {
            case self::COMPLETE : return "Complete"; break;
            case self::DRAFT : return "Draft"; break;
        }
    }

    public function getCurrencyEstimationCostAttribute()
    {
        return number_format($this->estimation_cost,0,',','.');
    }

    public function getMaintenanceTypeNameAttribute()
    {
        return $this->maintenance_type->name;
    }

    public function getPriorityNameAttribute()
    {
        return $this->priority->name;
    }

    public function getAssetNameAttribute()
    {
        return $this->asset->name;
    }

    /*******************************
     ** RELATION
     *******************************/
    public function created_user() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_user() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function maintenance_type()
    {
        return $this->belongsTo(TipeMaintenance::class, 'maintenance_type_id');

    }

    public function asset()
    {
        return $this->belongsTo(Aset::class, 'asset_id');
    }

    public function priority()
    {
        return $this->belongsTo(PrioritasAset::class, 'priority_id');
    }

    /*******************************
     ** SCOPE
     *******************************/
    public function scopeGrid($query)
    {
        return $query->latest();
    }

    public function scopeFilters($query)
    {
        return $query->filterBy(['work_order_id']);
    }

    /*******************************
     ** SAVING
     *******************************/
    public function handleStoreOrUpdate($request)
    {
        $this->beginTransaction();
        try {
            $data = $this->createInsertUpdateData($request);
            $this->fill($data);
            $this->save();

            return $this->commitSaved();    
        } catch (\Exception $e) {
            return $this->rollbackSaved($e);
        }
    }

    public function handleDestroy()
    {
        $this->beginTransaction();
        try {
            $this->handleDestroyFile([json_decode($this->attachment, true)]);

            $instructions = json_decode($this->instruction, true);

            foreach ($instructions as $instruction) {
                $this->handleDestroyFile($instruction['attachments']);
            }

            $this->delete();

            return $this->commitDeleted();    
        } catch (\Exception $e) {
            return $this->rollbackDeleted($e);
        }
    }

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
    private function createInsertUpdateData($request){
        $data = $request->all();
        $data['done_target_date'] = $this->formatDate($request->done_target_date);
        $data['estimation_cost'] = self::toNumber($request->estimation_cost);
        $data['other_costs'] = json_encode($request->other_costs);
        $data['instruction'] = json_encode($request->instruction);
        $data['user_id'] = json_encode($request->user_id);
        // $data['attachment'] = json_encode($request->attachment);
        $data['attachment'] = $request->attachments ? json_encode($request->attachments) : $this->attachment;
        $data['attachments_instruction_input'] = json_encode($request->attachments_instruction_input);

        $data['status'] = $request->is_submit;
        
        return $data;
    }

    public function canDeleted()
    {
        return true;
    }

    public static function formatDate($date, $from = 'd/m/Y', $to = 'Y-m-d')
    {
        return Carbon::createFromFormat($from, $date)->format($to);
    }

    public static function toNumber($string)
    {
        return (int)str_replace(".","", $string);
    }

    public function handleDestroyFile($files)
    {
        if($files != null){
            if(count($files) > 0){
                foreach ($files as $file) {
                    if(isset($file['path'])){
                        unlink(public_path() . '/' . $file['path']);
                    }
                }
            }
        }
    }

}
