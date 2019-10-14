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
        'cnae','simples_nacional','produto_rural','id_type_client_activity',
        'active','logo'

    ];

    public function typeActivity()
    {
        return $this->hasOne('App\Cliet\TypeActivity','id','id_type_client_activity');
    }
}
