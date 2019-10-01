<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_has_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('budget_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->integer('count')->unsigned();
            $table->string('obs');
            $table->timestamps();
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_has_services');
    }
}
