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
        Schema::create('boleta_local_productatribute', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('boleta_id')->nullable();
            $table->foreign('boleta_id')->references('id')->on('boletas')->onDelete('cascade');

            $table->unsignedBigInteger('local_productatribute_id')->nullable();
            $table->foreign('local_productatribute_id')->references('id')->on('local_productatribute')->onDelete('cascade');

            $table->double('quantity')->nullable();
            $table->double('price')->nullable();
            $table->double('subtotal')->nullable();

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
        Schema::dropIfExists('boleta_local_productatribute');
    }
};
