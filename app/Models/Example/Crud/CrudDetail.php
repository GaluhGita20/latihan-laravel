<?php

namespace App\Models\Example\Crud;

use App\Models\Auth\User;
use App\Models\Master\Example\Example;
use App\Models\Model;

class CrudDetail extends Model
{
    protected $table = 'trans_cruds_details';

    protected $fillable = [
        'crud_id',
        'example_id',
        'user_id',
        'description',
    ];

    /*******************************
     ** MUTATOR
     *******************************/

    /*******************************
     ** ACCESSOR
     *******************************/

    /*******************************
     ** RELATION
     *******************************/
    public function crud()
    {
        return $this->belongsTo(Crud::class, 'crud_id');
    }

    public function example()
    {
        return $this->belongsTo(Example::class, 'example_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*******************************
     ** SCOPE
     *******************************/

    /*******************************
     ** SAVING
     *******************************/

    /*******************************
     ** OTHER FUNCTIONS
     *******************************/
}
