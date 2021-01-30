<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'hak_akses'=>'0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Rekam Medis',
            'email' => 'rekam@mkcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('rekam'),
            'hak_akses'=>'1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Perawat',
            'email' => 'perawat@mkcare.com',
            'email_verified_at' => now(),
            'password' => Hash::make('perawat'),
            'hak_akses'=>'2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
