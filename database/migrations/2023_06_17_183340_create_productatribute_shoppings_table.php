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
        Schema::create('productatribute_shoppings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shopping_id');
            $table->foreign('shopping_id')->references('id')->on('shoppings')->onDelete('cascade');

            $table->unsignedBigInteger('productatribute_id');
            $table->foreign('productatribute_id')->references('id')->on('productatributes')->onDelete('cascade');

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
        Schema::dropIfExists('productatribute_shoppings');
    }
};
