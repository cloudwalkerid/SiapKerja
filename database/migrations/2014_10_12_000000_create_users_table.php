<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('seksi', function (Blueprint $table) {
            $table->string('id', 3)->primary();
            $table->string('nama', 100);

            $table->engine = 'InnoDB';
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('nip_baru', 30)->unique();
            $table->string('nip_lama', 10)->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 100);
            $table->string('golongan_terakhir', 30);
            $table->string('status_kendaraan', 1);
            $table->string('seksi_id', 3)->nullable(); //nomor surat
            $table->string('is_kasi_plt',1); //0 bukan 1 kasi 2 plt
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->engine = 'InnoDB';
        });

        Schema::create('mitra', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama', 100);

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra');
        Schema::dropIfExists('seksi');
        Schema::dropIfExists('users');
    }
}
