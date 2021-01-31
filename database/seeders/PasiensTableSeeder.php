<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
 
class PasiensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$faker = Faker::create('id_ID');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('pasiens')->truncate();
    	for($i = 1; $i <= 100; $i++){
            $jk = $faker->randomElement(['pria', 'wanita']);
			if ($jk == "pria") {
				$gender = "male";
			} else {
				$gender = "female";
			}
            
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('pasiens')->insert([
                'nik' => $faker->nik,
             'no_mkcare'=> $faker->numerify('0#-####-201#'),
               
              'no_jkn'=>$faker->ean13,
    			'nama' => $faker->name,
    			'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date($format = 'Y-m-d',$max = '2010-12-31'),
                'alamat'=>$faker->address,
                'jenis_kelamin'=>$jk,
                'nomor_wa' => $faker->phoneNumber,
                'nomor_hp'=> $faker->phoneNumber,
                'email'=>$faker->email,
                'id_user'=>0,
                'created_at' => now(),
                'updated_at' => now()
    		]);
 
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
 
    }
}
