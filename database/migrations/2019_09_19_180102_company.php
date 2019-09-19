<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('cnpj',14)->unique();;
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('telefone');
            $table->string('contato');
            $table->string('endereco');
            $table->string('endereco_numero');
            $table->string('endereco_bairro');
            $table->string('endereco_complemento')->nullable();
            $table->char('endereco_estado',2);
            $table->string('endereco_cidade');
            $table->char('endereco_cep',8);
            $table->string('telefone_2')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->date('abertura')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('cnae_principal')->nullable();
            $table->enum('tipo_atividade',
            ['Comercial (Varejista)','Industrial','Prestação de Serviços','Construção Civil',
             'Comercial (Atacadista)','Comercial (Exportadora)','Importador (varejista)',
             'Importador (Atacadista)'])->nullable();
            $table->enum('regime_tributario',
            ['Simples Nacional','Simples Nacional - excesso de sublime de receita',
             'Regime Normal - Lucro Presumido','Regime Normal - Lucro Real',
             'Produtor Rural'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
