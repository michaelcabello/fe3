<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Local;
use App\Models\Productatribute;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Local::create([
            'codigopostal' => '15465',
            'address' => 'Av. petit Thouars 1255',
            'phone' => '2662540',
            'movil' => '996929478',
            'anexo' => 'anexo1',
            'serie' => '10',
            'state' => 1,
            'user_id'=> 1,
        ]);

        Local::create([
            'codigopostal' => '20654',
            'address' => 'Av. pizarro 999',
            'phone' => '7959969',
            'movil' => '996587414',
            'anexo' => 'anexo2',
            'serie' => '20',
            'state' => 1,
            'user_id'=> 2,
        ]);


        Local::create([
            'codigopostal' => '303069',
            'address' => 'Av. Mexico 888',
            'phone' => '4185965',
            'movil' => '99887755',
            'anexo' => 'anexo3',
            'serie' => '30',
            'state' => 1,
            'user_id'=> 3,
        ]);

        Local::create([
            'codigopostal' => '999069',
            'address' => 'Av. galvez 778',
            'phone' => '5435965',
            'movil' => '99876755',
            'anexo' => 'anexo4',
            'serie' => '40',
            'state' => 1,
            'user_id'=> 4,
        ]);





    }
}
