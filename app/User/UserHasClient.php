<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class UserHasClient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id',
    ];

    protected $table = 'user_has_clients';

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function client()
    {
        return $this->hasOne('App\Client\Client','id','client_id');
    }
}
