<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipocomprobante;

class TipocomprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipocomprobante::create([
            'name' => 'FACTURA',    
            'state' => 1,           
        ]);

        Tipocomprobante::create([
            'name' => 'BOLETA',    
            'state' => 1,           
        ]);

        
        Tipocomprobante::create([
            'name' => 'NOTA DE CREDITO',    
            'state' => 1,           
        ]);

        Tipocomprobante::create([
            'name' => 'NOTA DE DEBITO',    
            'state' => 1,           
        ]);
    }
}
