<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();;
            $table->date('fechaenvio')->nullable();
            $table->date('fechaaceptacion')->nullable();
            $table->string('state')->default(1);//para ver la confirmacion si ya recibio
            //$table->integer('numero');

            $table->double('total', 8, 2)->nullable();//precio venta

            $table->unsignedBigInteger('local_envia_id')->nullable();//local que envia
            $table->foreign('local_envia_id')->references('id')->on('locals')->onDelete('cascade');

            $table->unsignedBigInteger('local_recibe_id')->nullable();//local que recibe
            $table->foreign('local_recibe_id')->references('id')->on('locals')->onDelete('cascade');

            $table->text('nota')->nullable();

            $table->unsignedBigInteger('userqueacepta_id')->nullable();
            $table->foreign('userqueacepta_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('user_recibe_id')->nullable();//usuario que recibe la notificacion
            $table->foreign('user_recibe_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('shipments');
    }
};
