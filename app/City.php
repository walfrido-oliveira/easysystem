<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name','uf'
    ];

    public function uf()
    {
        return $this->hasOne('App\Uf','id','uf');
    }
}
