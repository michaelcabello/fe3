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
        Schema::create('local_productatribute_shipments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');

            $table->unsignedBigInteger('local_productatribute_id');
            $table->foreign('local_productatribute_id')->references('id')->on('local_productatribute')->onDelete('cascade');

            $table->double('quantity');

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
        Schema::dropIfExists('local_productatribute_shipments');
    }
};
