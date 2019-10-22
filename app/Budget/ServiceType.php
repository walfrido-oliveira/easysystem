<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'tse_id','desc','tse_pct_iss',
        'tse_isen_iss','tse_n_reter_iss',
        'tse_cod_tribut_mun'
    ];
}
