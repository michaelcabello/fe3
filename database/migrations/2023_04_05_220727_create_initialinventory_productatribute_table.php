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
        Schema::create('initialinventory_productatribute', function (Blueprint $table) {
            $table->id();
            //$table->primary('initialinventory_id','productatribute_id');
            $table->decimal('stock');

            $table->unsignedBigInteger('initialinventory_id');
            $table->foreign('initialinventory_id')->references('id')->on('initialinventories')->onDelete('cascade');

            $table->unsignedBigInteger('productatribute_id');
            $table->foreign('productatribute_id')->references('id')->on('productatributes')->onDelete('cascade');

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
        Schema::dropIfExists('initialinventory_productatribute');
    }
};
