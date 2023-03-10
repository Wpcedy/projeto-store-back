<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->json('produtos');
            $table->char('status', 1);
            $table->double('valorpedido', 8, 2);
            $table->dateTime('datapedido', $precision = 0);;
            $table->timestamps();
            $table->integer('cliente')->unsigned();
            $table->foreign('cliente')->references('id')->on('clientes');
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
