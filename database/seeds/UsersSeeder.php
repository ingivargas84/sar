<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();

        $superadminRole = Role::create(['name' => 'Super-Administrador']);
        $adminRole = Role::create(['name' => 'Administrador']);
        $meseroRole = Role::create(['name' => 'Mesero']);
        $cobradorRole = Role::create(['name' => 'Cobrador']);
        $cocinaRole = Role::create(['name' => 'Cocina']);

        $user = new user;
        $user->name = 'Super Administrador';
        $user->email= 'superadmin@gmail.com';
        $user->password = bcrypt('superadmin');
        $user->username = 'superadmin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($superadminRole); 

        $user = new user;
        $user->name = 'Administrador';
        $user->email= 'admin@gmail.com';
        $user->password = bcrypt('admin');
        $user->username = 'admin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($adminRole);

        $user = new user;
        $user->name = 'Mesero';
        $user->email= 'mesero@gmail.com';
        $user->password = bcrypt('mesero');
        $user->username = 'mesero';
        $user->estado = 1;
        $user->save();
        $user->assignRole($meseroRole); 

        $user = new user;
        $user->name = 'Cajero';
        $user->email= 'cajero@gmail.com';
        $user->password = bcrypt('cajero');
        $user->username = 'cajero';
        $user->estado = 1;
        $user->save();
        $user->assignRole($cobradorRole); 

        $user = new user;
        $user->name = 'Cocina';
        $user->email= 'cocina@gmail.com';
        $user->password = bcrypt('cocina');
        $user->username = 'cocina';
        $user->estado = 1;
        $user->save();
        $user->assignRole($cocinaRole);  
        
    }
}
