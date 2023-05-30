<?php

use App\Models\Initialinventory;
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
        Schema::create('initialinventories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default("Inventario Inicial");
            $table->date('datestart');
            $table->date('dateend')->nullable();
            $table->unsignedBigInteger('local_id');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('note')->nullable();
            $table->string('observation')->nullable();

            $table->enum('state', [Initialinventory::NOINICIADO, Initialinventory::ENPROCESO, Initialinventory::TERMINADO])->default(Initialinventory::NOINICIADO);


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
        Schema::dropIfExists('initialinventories');
    }
};
