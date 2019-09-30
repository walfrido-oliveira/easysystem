<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'id_sgv','desc','area_id','type','local',
        'value','active'
    ];

    public function area()
    {
        return $this->hasOne('App\Budget\Area','id','area_id');
    }
}
