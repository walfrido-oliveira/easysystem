<?php

namespace App\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'cnpj','razao_social','nome_fantasia','ddd',
        'phone','contact','adress','number','district',
        'complement','state','city','cep','ddd_2',
        'phone_2','mail','website','ie','im','suframa',
        'cnae','simples_nacional','produtor_rural','id_type_client_activity',
        'active','logo','obs'

    ];

    public function typeActivity()
    {
        return $this->hasOne('App\Cliet\TypeActivity','id','id_type_client_activity');
    }

    protected $rootPath = 'clients\\';

    public function getPathAttribute()
    {
        return $this->rootPath . str_pad((string)$this->id, 20, "0", STR_PAD_LEFT);
    }
}
