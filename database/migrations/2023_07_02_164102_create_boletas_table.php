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
        Schema::create('boletas', function (Blueprint $table) {
            $table->id();

            $table->string('serie');
            $table->integer('numero');
            $table->string('serienumero');
            $table->timestamp('fechaemision')->nullable();
            $table->timestamp('fechavencimiento')->nullable();
            //$table->string('formadepago');
            $table->double('total', 8, 2)->nullable();//precio venta

            $table->unsignedBigInteger('comprobante_id')->nullable();
            $table->foreign('comprobante_id')->references('id')->on('comprobantes')->onDelete('cascade');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');


            $table->unsignedBigInteger('paymenttype_id')->nullable();
            $table->foreign('paymenttype_id')->references('id')->on('paymenttypes')->onDelete('cascade');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

            $table->unsignedBigInteger('tipodecambio_id')->nullable();
            $table->foreign('tipodecambio_id')->references('id')->on('tipodecambios')->onDelete('cascade');


            /* $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade'); */

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
        Schema::dropIfExists('boletas');
    }
};
