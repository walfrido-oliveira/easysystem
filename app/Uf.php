<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UF extends Model
{
    protected $fillable = [
        'name','uf'
    ];

    protected $table = 'ufs';
}
