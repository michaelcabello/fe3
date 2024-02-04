<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocalTipocomprobantesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('local_tipocomprobantes')->delete();
        
        \DB::table('local_tipocomprobantes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'serie' => 'F001',
                'inicio' => 0,
                'default' => 1,
                'local_id' => 1,
                'tipocomprobante_id' => 1,
                'company_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'serie' => 'B001',
                'inicio' => 20,
                'default' => 1,
                'local_id' => 1,
                'tipocomprobante_id' => 2,
                'company_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}