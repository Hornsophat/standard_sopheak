<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Copy1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payment', function (Blueprint $table) {

            $table->increments('id'); 
            $table->integer('sale_id');
            $table->date('payment_date');
            $table->date('actual_payment_date');
            $table->string('amount_to_spend');
            $table->string('total_commission');
            $table->string('status');
          
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
