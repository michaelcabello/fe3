<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Inventory;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->date('datestart')->nullable();
            $table->date('dateend')->nullable();
            $table->unsignedBigInteger('local_id');
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('note')->nullable();
            $table->string('observation')->nullable();

            $table->enum('state', [Inventory::ENPROCESO, Inventory::TERMINADO])->default(Inventory::ENPROCESO);

            $table->double('totalfaltante')->nullable();
            $table->double('totalsobrante')->nullable();




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
        Schema::dropIfExists('inventories');
    }
};
