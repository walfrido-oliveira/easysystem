<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name','active','service_category_type_id'
    ];

    public function type()
    {
        return $this->hasOne('App\Budget\ServiceCategoryType','id','service_category_type_id');
    }
}
