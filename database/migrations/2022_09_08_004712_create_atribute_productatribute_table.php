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
        Schema::create('atribute_productatribute', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('productatribute_id');
            $table->unsignedBigInteger('atribute_id');

            $table->foreign('productatribute_id')->references('id')->on('productatributes')->onDelete('cascade');
            $table->foreign('atribute_id')->references('id')->on('atributes')->onDelete('cascade');



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
        Schema::dropIfExists('atribute_productatribute');
    }
};
