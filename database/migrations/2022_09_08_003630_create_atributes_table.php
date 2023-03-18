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
        Schema::create('atributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('state')->default(false);
            $table->integer('order')->nullable();

            $table->unsignedBigInteger('groupatribute_id')->nullable();
            $table->foreign('groupatribute_id')->references('id')->on('groupatributes')->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('atributes');
    }
};
