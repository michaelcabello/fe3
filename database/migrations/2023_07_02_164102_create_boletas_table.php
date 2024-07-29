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
            $table->double('total', 10, 4)->nullable();//precio venta

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

            $table->string('send_xml')->nullable();
            $table->string('sunat_success')->nullable();
            $table->text('sunat_error')->nullable();
            $table->string('hash')->nullable();
            $table->string('xml_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('sunat_cdr_path')->nullable();
            $table->text('cdr_code')->nullable();
            $table->text('cdr_notes')->nullable();
            $table->text('cdr_description')->nullable();

            //para controlar las boletas enviadas por resumen
            $table->unsignedBigInteger('resumen_id')->nullable();
            $table->foreign('resumen_id')->references('id')->on('resumens')->onDelete('cascade');

            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('cascade');


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
