<?php

namespace App\Budget;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'contact','client','client_id','phone',
        'mail','payment_id','transport_id','obs'
    ];

    public function transport()
    {
        return $this->hasOne('App\Budget\Transport','id','transport_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Budget\Payment','id','payment_id');
    }
}
