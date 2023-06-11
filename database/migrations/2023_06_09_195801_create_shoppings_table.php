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
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();

            $table->date('fechaemision')->nullable();
            $table->date('fechavencimiento')->nullable();
            $table->string('serienumero');
            //$table->integer('numero');
            $table->double('subtotal', 8, 2)->nullable();//precio venta
            $table->double('igv', 8, 2)->nullable();//precio venta
            $table->double('total', 8, 2)->nullable();//precio venta
            $table->string('formadepago')->nullable();

            $table->unsignedBigInteger('tipocomprobante_id')->nullable();
            $table->foreign('tipocomprobante_id')->references('id')->on('tipocomprobantes')->onDelete('cascade');

            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            $table->unsignedBigInteger('tipodecambio_id')->nullable();
            $table->foreign('tipodecambio_id')->references('id')->on('tipodecambios')->onDelete('cascade');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

            //indicara el usuario que esta realizando la compra
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //

            $table->text('nota')->nullable();

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
        Schema::dropIfExists('shoppings');
    }
};
