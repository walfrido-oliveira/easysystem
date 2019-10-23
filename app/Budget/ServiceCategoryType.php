<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class ServiceCategoryType extends Model
{
    protected $fillable = [
        'name','active'
    ];
}
