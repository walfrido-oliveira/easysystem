<?php

namespace App\Client;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name','active'
    ];

    protected $table = 'type_client_activitys';
}
