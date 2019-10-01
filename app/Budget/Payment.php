<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name','active'
    ];
}
