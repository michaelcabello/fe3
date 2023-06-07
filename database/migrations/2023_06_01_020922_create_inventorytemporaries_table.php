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
        Schema::create('inventorytemporaries', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->text('name');//pondremos el slug
            $table->double('stocksistema');
            $table->double('stockcontado');
            $table->double('diferencia');

            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

            $table->unsignedBigInteger('local_id');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('cascade');

            $table->unsignedBigInteger('local_productatribute_id');
            $table->foreign('local_productatribute_id')->references('id')->on('local_productatribute')->onDelete('cascade');

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
        Schema::dropIfExists('inventorytemporaries');
    }
};
