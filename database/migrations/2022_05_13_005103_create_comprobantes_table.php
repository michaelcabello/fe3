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
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();

            //$table->double('total', 8, 2)->nullable();//precio venta
            //$table->string('formadepago')->nullable();
            //$table->string('numeroguia')->nullable();
            //relacion de uno a muchos polimorfica con factura boleta guia
            //$table->unsignedBigInteger('comprobanteable_id');
            //$table->string('comprobanteable_type');
            //relacion de uno a uno polimorfica con factura boleta guia
            //$table->unsignedBigInteger('comprobanteable_id');
            //$table->string('comprobanteable_type');
            //$table->primary(['comprobanteable_id', 'comprobanteable_type']);//no debe repetirse

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('local_id')->nullable();
            $table->foreign('local_id')->references('id')->on('locals')->onDelete('cascade');

            $table->unsignedBigInteger('tipocomprobante_id')->nullable();
            $table->foreign('tipocomprobante_id')->references('id')->on('tipocomprobantes')->onDelete('cascade');

            $table->unsignedBigInteger('local_tipocomprobante_id')->nullable();
            $table->foreign('local_tipocomprobante_id')->references('id')->on('local_tipocomprobantes')->onDelete('cascade');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');


            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('tipodeoperacion_id')->nullable();
            $table->foreign('tipodeoperacion_id')->references('id')->on('tipodeoperacions')->onDelete('cascade');

            //$table->unsignedBigInteger('currency_id')->nullable();
            //$table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

            $table->timestamp('fechaemision')->nullable();
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
        Schema::dropIfExists('comprobantes');
    }
};
