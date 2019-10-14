<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'desc','area_id','type','local',
        'value','active','range'
    ];

    public function area()
    {
        return $this->hasOne('App\Budget\Area','id','area_id');
    }
}
