<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PimpinanSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'nama_lengkap' => 'Pimpinan Kemensos',
            'username' => 'pimpinan',
            'password' => Hash::make('pimpinan123'),
            'email' => 'pimpinan@kemensos.go.id',
            'role' => 'pimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

