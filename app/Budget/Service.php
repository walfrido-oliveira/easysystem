<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'desc','area_id','type','local',
        'value','active','range','taxation_id',
        'cm','service_type_id','nbs','service_category_id'
    ];

    public function area()
    {
        return $this->hasOne('App\Budget\Area','id','area_id');
    }

    public function taxation()
    {
        return $this->hasOne('App\Budget\Taxation','id','taxation_id');
    }

    public function serviceType()
    {
        return $this->hasOne('App\Budget\ServiceType','tse_id','service_type_id');
    }

    public function category()
    {
        return $this->hasOne('App\Budget\ServiceCategory','id','service_category_id');
    }
}
