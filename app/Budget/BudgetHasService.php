<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetHasService extends Model
{
    protected $fillable = [
        'budget_id','service_id','count','obs',
    ];

    public function budget()
    {
        return $this->hasOne('App\Budget\Budget','id','budget_id');
    }

    public function service()
    {
        return $this->hasOne('App\Budget\Service','id','service_id');
    }
}
