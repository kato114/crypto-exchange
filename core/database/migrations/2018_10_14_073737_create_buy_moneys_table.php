<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyMoneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_moneys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id')->unsigned();
            $table->string('enter_amount')->nullable();
            $table->string('buy_rate')->nullable();
            $table->string('buy_charge')->nullable();
            $table->string('get_amount')->nullable();
            $table->string('trx')->nullable();
            $table->string('account')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('info')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('buy_moneys');
    }
}
