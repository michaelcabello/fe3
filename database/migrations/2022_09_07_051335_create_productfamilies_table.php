<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Productfamilie;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productfamilies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('state')->default(true);
           // $table->boolean('simplecompound')->default(true);//0false simple, 1true compuesto

            $table->enum('tipo', [Productfamilie::PRODUCTOTERMINADO, Productfamilie::MERCADERIA, Productfamilie::SERVICIO])->default(Productfamilie::PRODUCTOTERMINADO);

            $table->boolean('haveserialnumber')->default(false);
            $table->string('gender')->nullable();//varon 1 mujer 2 unixex 3
            $table->boolean('flag')->default(false);//para indicar si el producto ya se termino de crear

            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');

       /*      $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); */

            $table->unsignedBigInteger('modelo_id')->nullable();
            $table->foreign('modelo_id')->references('id')->on('modelos')->onDelete('cascade');

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('productfamilies');
    }

};
