<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'codigo' => '1',
            'codigobarras' => '1b',
            'name' => 'camisa',
            'description' => 'descripcion de camisa',
            'purchaseprice' => 98,
            'saleprice' => 110,
            'salepricemin' => 100,
            'company_id'=> 1,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '2',
            'codigobarras' => '2b',
            'name' => 'polo',
            'description' => 'descripcion de polo',
            'purchaseprice' => 50,
            'saleprice' => 70,
            'salepricemin' => 60,
            'company_id'=> 1,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '3',
            'codigobarras' => '3ax',
            'name' => 'pantalon',
            'description' => 'descripcion de pantalon',
            'purchaseprice' => 53,
            'saleprice' => 73,
            'salepricemin' => 63,
            'company_id'=> 1,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '4',
            'codigobarras' => '4ax',
            'name' => 'casaca',
            'description' => 'descripcion de casaca',
            'purchaseprice' => 57,
            'saleprice' => 77,
            'salepricemin' => 67,
            'company_id'=> 1,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);


        Product::create([
            'codigo' => '5',
            'codigobarras' => '5mn',
            'name' => 'buzo',
            'description' => 'descripcion de buzo',
            'purchaseprice' => 83,
            'saleprice' => 103,
            'salepricemin' => 93,
            'company_id'=> 1,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);




        Product::create([
            'codigo' => '11',
            'codigobarras' => '1bb',
            'name' => 'camisa',
            'description' => 'descripcion de camisa',
            'purchaseprice' => 98,
            'saleprice' => 110,
            'salepricemin' => 100,
            'company_id'=> 2,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '12',
            'codigobarras' => '2bb',
            'name' => 'polo',
            'description' => 'descripcion de polo',
            'purchaseprice' => 50,
            'saleprice' => 70,
            'salepricemin' => 60,
            'company_id'=> 2,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '13',
            'codigobarras' => '3axx',
            'name' => 'pantalon',
            'description' => 'descripcion de pantalon',
            'purchaseprice' => 53,
            'saleprice' => 73,
            'salepricemin' => 63,
            'company_id'=> 2,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);

        Product::create([
            'codigo' => '14',
            'codigobarras' => '4axx',
            'name' => 'casaca',
            'description' => 'descripcion de casaca',
            'purchaseprice' => 57,
            'saleprice' => 77,
            'salepricemin' => 67,
            'company_id'=> 2,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);


        Product::create([
            'codigo' => '15',
            'codigobarras' => '5mnn',
            'name' => 'buzo',
            'description' => 'descripcion de buzo',
            'purchaseprice' => 83,
            'saleprice' => 103,
            'salepricemin' => 93,
            'company_id'=> 2,
            'currency_id'=> 1,
            'um_id'=> 1,
            'modelo_id'=> 1,
            'category_id'=> 1,
            'tipoafectacion_id'=> 1,
            'brand_id'=> 1,
            'state' => 1,
        ]);




    }
}
