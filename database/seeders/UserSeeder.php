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

        Permission::create(['name'=>'Web View','display_name'=>'Ver Web'])->SyncRoles([$adminRole]);//para que oculte o muestre los campos de web
        Permission::create(['name'=>'Export Excel','display_name'=>'Export Excel'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Export Pdf','display_name'=>'Export Pdf'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Import Excel','display_name'=>'Import Excel'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Banner Export','display_name'=>'Banner Export'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Sale View','display_name'=>'Ver Ventas'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Sale Create','display_name'=>'Crear Ventas'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Sale Update','display_name'=>'Actualizar Ventas'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Sale Delete','display_name'=>'Eliminar Ventas'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Shopping View','display_name'=>'Ver Compras'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Shopping Create','display_name'=>'Crear Compras'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Shopping Update','display_name'=>'Actualizar Compras'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Shopping Delete','display_name'=>'Eliminar Compras'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Inventory View','display_name'=>'Ver Inventario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Inventory Create','display_name'=>'Crear Inventario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Inventory Update','display_name'=>'Actualizar Inventario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Inventory Delete','display_name'=>'Eliminar Inventario'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Initialinventory View','display_name'=>'Ver Inventario Inicial'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Initialinventory Create','display_name'=>'Crear Inventario Inicial'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Initialinventory Update','display_name'=>'Actualizar Inventario Inicial'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Initialinventory Delete','display_name'=>'Eliminar Inventario Inicial'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Product View','display_name'=>'Ver Productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Product Create','display_name'=>'Crear Productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Product Update','display_name'=>'Actualizar Productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Product Delete','display_name'=>'Eliminar Productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Configuration View','display_name'=>'Ver Configuración'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Configuration Create','display_name'=>'Crear Configuración'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Configuration Update','display_name'=>'Actualizar Configuración'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Configuration Delete','display_name'=>'Eliminar Configuración'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Modelo View','display_name'=>'Ver Modelo de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Modelo Create','display_name'=>'Crear Modelo de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Modelo Update','display_name'=>'Actualizar Modelo de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Modelo Delete','display_name'=>'Eliminar Modelo de productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Category View','display_name'=>'Ver Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Create','display_name'=>'Crear Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Update','display_name'=>'Actualizar Categoria de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Category Delete','display_name'=>'Eliminar Categoria de productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Brand View','display_name'=>'Ver Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Create','display_name'=>'Crear Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Update','display_name'=>'Actualizar Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Delete','display_name'=>'Eliminar Marca de productos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Brand Show','display_name'=>'Mostrar Marca de productos'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'User View','display_name'=>'Ver Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Create','display_name'=>'Crear Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Update','display_name'=>'Actualizar Usuario'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'User Delete','display_name'=>'Eliminar Usuario'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Role View','display_name'=>'Ver Roles'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Role Create','display_name'=>'Crear Roles'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Role Update','display_name'=>'Actualizar Roles'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Role Delete','display_name'=>'Eliminar Roles'])->SyncRoles([$adminRole]);

        Permission::create(['name'=>'Permission View','display_name'=>'Ver Permisos'])->SyncRoles([$adminRole]);
        Permission::create(['name'=>'Permission Update','display_name'=>'Actualizar Permisos'])->SyncRoles([$adminRole]);





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
            'local_id' => 1,
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
            'local_id' => 1,
            'position_id' => $positionseller->id,

        ]);


        $admin = User::create([
            'name' => 'luis',
            'email' => 'luis@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        //creando empleado vendedor seller
        Employee::create([
            'address' => 'Av lopez cadiz 1791',
            'movil' => '996559478',
            'dni' => '14533423',
            'gender' => 1,
            'user_id' => $admin->id,
            'local_id' => 2,
            'position_id' => $positionseller->id,

        ]);






        $admin = User::create([
            'name' => 'leydy',
            'email' => 'leydy@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        //creando empleado vendedor seller
        Employee::create([
            'address' => 'Av lopez cadiz 1791',
            'movil' => '996559478',
            'dni' => '14533423',
            'gender' => 1,
            'user_id' => $admin->id,
            'local_id' => 2,
            'position_id' => $positionseller->id,

        ]);





        $admin = User::create([
            'name' => 'flor',
            'email' => 'flor@ticomperu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        //creando empleado vendedor seller
        Employee::create([
            'address' => 'Av lopez cadiz 1791',
            'movil' => '996559478',
            'dni' => '14533423',
            'gender' => 1,
            'user_id' => $admin->id,
            'local_id' => 3,
            'position_id' => $positionseller->id,

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
