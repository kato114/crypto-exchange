<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeMoneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_moneys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('trx')->nullable();
            $table->string('from_amount')->nullable();
            $table->string('from_amount_charge')->nullable();
            $table->integer('from_currency_id')->nullable();
            $table->string('receive_amount')->nullable();
            $table->integer('receive_currency_id')->nullable();
            $table->text('transaction_number')->nullable();
            $table->string('image')->nullable();
            $table->text('user_payment_id')->nullable();
            $table->tinyInteger('status')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('exchange_moneys');
    }
}
