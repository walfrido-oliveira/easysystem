<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetFiles extends Model
{
    protected $fillable = [
        'budget_id','url', 'name', 'mime', 'signed'
    ];

    public function budget()
    {
        return $this->hasOne('App\Budget\Budget','id','budget_id');
    }
}
