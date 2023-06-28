<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('codigopostal')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('movil')->nullable();
            $table->string('anexo')->nullable();
            $table->string('serie')->nullable();
            $table->boolean('state')->default(true);
            $table->integer('notification')->default(0);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::dropIfExists('locals');
    }
};
