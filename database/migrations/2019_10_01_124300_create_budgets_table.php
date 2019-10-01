<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact');
            $table->string('client');
            $table->string('cliente_id');
            $table->string('phone');
            $table->string('mail');
            $table->bigInteger('payment_id')->unsigned();
            $table->bigInteger('transport_id')->unsigned();
            $table->string('obs');
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('transport_id')->references('id')->on('transports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
