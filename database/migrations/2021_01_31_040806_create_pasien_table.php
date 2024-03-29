<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nik',16);
            $table->string('no_mkcare',20)->nullable();
            $table->string('no_jkn',20)->nullable();
            $table->string('nama',100);
            $table->string('tempat_lahir',100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['pria', 'wanita']);
            $table->string('alamat')->nullable();
            $table->integer('provinsi_id')->nullable();
            $table->integer('kabupaten_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->integer('kelurahan_id')->nullable();
            $table->string('nomor_wa',20)->nullable();
            $table->string('nomor_hp',20)->nullable();
            $table->string('email',100)->unique();
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
}
