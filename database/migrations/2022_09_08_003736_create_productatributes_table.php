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
        Schema::create('productatributes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->double('price');
            $table->double('state');

            $table->unsignedBigInteger('productfamilie_id')->nullable();
            $table->foreign('productfamilie_id')->references('id')->on('productfamilies')->onDelete('cascade');

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
        Schema::dropIfExists('productatributes');
    }
};
