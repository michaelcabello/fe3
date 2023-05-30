<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Str;

//importamos para asignar roles y permisos
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{

    public function run()
    {

        $adminRole = Role::create(['name'=>'Admin','display_name'=>'Administrador']);
        $sellerRole = Role::create(['name'=>'Seller','display_name'=>'Vendedor']);
        $grocerRole = Role::create(['name'=>'Grocer','display_name'=>'Alamacenero']);


        Permission::create(['name'=>'Category View','display_name'=>'Ver Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Create','display_name'=>'Crear Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Update','display_name'=>'Actualizar Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Delete','display_name'=>'Eliminar Categoria de productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Brand View','display_name'=>'Ver Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Create','display_name'=>'Crear Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Update','display_name'=>'Actualizar Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Delete','display_name'=>'Eliminar Marca de productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'User View','display_name'=>'Ver Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Create','display_name'=>'Crear Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Update','display_name'=>'Actualizar Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Delete','display_name'=>'Eliminar Usuario'])->SyncRoles([$adminRole]);

        //creando posicion o profesion o cargo
        $positionadmin = Position::create([
            'name' => 'Administrador',
        ]);
        $positionseller = Position::create([
            'name' => 'Vendedor',
        ]);




        //creando usuario admin
        $admin = User::create([
            'name' => 'Michael',
            'email' => 'michael@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole($adminRole);

        //creando empleado admin
        Employee::create([
            'address' => 'Av Jose galvez 1731',
            'movil' => '996929478',
            'dni' => '10133423',
            'gender' => 1,
            'user_id' => $admin->id,
            'position_id' => $positionadmin->id,

        ]);



        //creando usuario vendor
        $seller = User::create([
            'name' => 'joffre',
            'email' => 'joffre@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $seller->assignRole($sellerRole);


        //creando empleado vendedor seller
        Employee::create([
            'address' => 'Av lopez cadiz 1791',
            'movil' => '996559478',
            'dni' => '14533423',
            'gender' => 1,
            'user_id' => $seller->id,
            'position_id' => $positionseller->id,

        ]);


        $admin = User::create([
            'name' => 'luis',
            'email' => 'luis@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $admin = User::create([
            'name' => 'leydy',
            'email' => 'leydy@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $admin = User::create([
            'name' => 'flor',
            'email' => 'flor@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        //creando usuarioa sin employee, da error al mostrar datos por eso lo comente
/*         User::create([
            'name' => 'pepe',
            'email' => 'pepe@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'deyna',
            'email' => 'deyna@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]); */
    }
}
