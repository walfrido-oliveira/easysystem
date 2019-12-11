<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetFiles extends Model
{
    protected $fillable = [
        'budget_id','url', 'name', 'mime'
    ];

    public function budget()
    {
        return $this->hasMany('App\Budget\Budget','budget_id','id');
    }
}
