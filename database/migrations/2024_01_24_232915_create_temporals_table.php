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
        Schema::create('temporals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->string('codigobarras');
            $table->foreignId('employee_id')->constrained();//para identificarla venta del usuario o empleado
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('um');
            $table->string('tipafeigv');
            $table->decimal('saleprice', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('salepricef', 10, 2)->nullable();
            $table->integer('quantity');
            //$table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->timestamps();
            $table->unique(['company_id', 'codigobarras']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporals');
    }
};
