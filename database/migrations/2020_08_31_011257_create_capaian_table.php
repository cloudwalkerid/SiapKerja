<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('siap_kerja_ref_kegiatan_tahapan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_kode', 10)->unique();
            $table->string('nama', 100);
            $table->smallInteger('bobot')->unsigned();
        });
        Schema::create('siap_kerja_kegiatan', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('seksi_id', 3);
            $table->string('nama', 100);
            $table->integer('anggaran')->unsigned();
            $table->string('tahun', 4);

            $table->double('capaian_01', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_02', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_03', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_04', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_05', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_06', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_07', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_08', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_09', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_10', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_11', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_12', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_total', 6, 3);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_kegiatan_pj', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('kegiatan_id', 36);
            $table->string('nip_lama', 10);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['kegiatan_id', 'nip_lama']);
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('nip_lama')->references('nip_lama')->on('users');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_kegiatan_tahapan', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('seksi_id', 3);
            $table->string('kegiatan_id', 36);
            $table->string('nama', 100);
            $table->string('satuan', 20);
            $table->integer('target_all');
            $table->string('ref_kode', 10);
            $table->smallInteger('bobot_kegiatan_tahapan')->unsigned();
            $table->date('awal');
            $table->date('akhir');
            $table->tinyInteger('bulan_awal')->unsigned();
            $table->tinyInteger('bulan_akhir')->unsigned();
            $table->string('is_mulai', 1); // 1=> 1 mulai 0 tidak mulai
            $table->string('yang_isi', 1); //  2=> 0 seksi yang isi 1 indiviu yang is 
            $table->string('status_spd', 1);
            $table->string('tahun', 4);

            $table->double('capaian_01', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_02', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_03', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_04', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_05', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_06', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_07', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_08', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_09', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_10', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_11', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_12', 6, 3)->nullable()->default(NULL);
            $table->double('capaian_total', 6, 3);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('ref_kode')->references('ref_kode')->on('siap_kerja_ref_kegiatan_tahapan');
            $table->engine = 'InnoDB';
            
        });

        Schema::create('siap_kerja_kegiatan_tahapan_spd', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('seksi_id', 3);
            $table->string('kegiatan_id', 36);
            $table->string('kegiatan_tahapan_id', 36);
            $table->string('nama', 100);
            $table->integer('target_all');
            $table->string('ref_kode', 10);
            $table->string('status_spd', 3);
            $table->date('spd_tanggal_awal');
            $table->date('spd_tanggal_akhir');
            $table->integer('spd_nomor_awal');
            $table->integer('spd_nomor_akhir');
            $table->string('program', 20);
            $table->string('keg_out_komp', 20);
            $table->integer('rate_penginapan');
            $table->integer('rate_uang_harian');
            $table->date('tanggal_pembuatan');
            $table->date('tanggal_ttd_kuitansi');
            $table->string('status_penginapan', 1);
            $table->string('status_tanggal_pembuatan', 1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('kegiatan_tahapan_id')->references('id')->on('siap_kerja_kegiatan_tahapan');
            $table->foreign('ref_kode')->references('ref_kode')->on('siap_kerja_ref_kegiatan_tahapan');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_kegiatan_tahapan_alokasi_dl', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('nip_lama', 10);
            $table->string('seksi_id', 3);
            $table->string('is_mulai', 1); // 1=> 1 mulai 0 tidak mulai
            $table->string('status_spd', 3);
            $table->string('kegiatan_id', 36);
            $table->string('kegiatan_tahapan_id', 36);
            $table->integer('jumlah_dl');
            $table->integer('real_jumlah_dl');
            $table->date('awal');
            $table->date('akhir');
            $table->string('tahun', 4);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('nip_lama')->references('nip_lama')->on('users');
            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('kegiatan_tahapan_id', 'tahapan_alokasi_foreign')->references('id')->on('siap_kerja_kegiatan_tahapan');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_DL', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('nip_lama', 10);
            $table->string('seksi_id', 3);
            $table->string('status_spd', 3);
            $table->string('kegiatan_id', 36);
            $table->string('kegiatan_tahapan_id', 36);
            $table->string('kegiatan_tahapan_alokasi_dl_id', 36);
            $table->string('tanggal', 2);
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('nip_lama')->references('nip_lama')->on('users');
            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('kegiatan_tahapan_id')->references('id')->on('siap_kerja_kegiatan_tahapan');
            $table->foreign('kegiatan_tahapan_alokasi_dl_id')->references('id')->on('siap_kerja_kegiatan_tahapan_alokasi_dl');
            $table->engine = 'InnoDB';
        });
       
        Schema::create('siap_kerja_capaian_tahapan', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('seksi_id', 3);
            $table->string('kegiatan_id', 36);
            $table->string('kegiatan_tahapan_id', 36);
            $table->smallInteger('target_all')->unsigned();
            $table->string('is_mulai', 1); // 1=> 1 mulai 0 tidak mulai
            $table->string('yang_isi', 1); //  2=> 0 seksi yang isi 1 indiviu yang is 
            $table->tinyInteger('bulan_awal')->unsigned();
            $table->tinyInteger('bulan_akhir')->unsigned();
            $table->string('tahun', 4);
            $table->smallInteger('target_01')->unsigned()->default(0);
            $table->smallInteger('target_02')->unsigned()->default(0);
            $table->smallInteger('target_03')->unsigned()->default(0);
            $table->smallInteger('target_04')->unsigned()->default(0);
            $table->smallInteger('target_05')->unsigned()->default(0);
            $table->smallInteger('target_06')->unsigned()->default(0);
            $table->smallInteger('target_07')->unsigned()->default(0);
            $table->smallInteger('target_08')->unsigned()->default(0);
            $table->smallInteger('target_09')->unsigned()->default(0);
            $table->smallInteger('target_10')->unsigned()->default(0);
            $table->smallInteger('target_11')->unsigned()->default(0);
            $table->smallInteger('target_12')->unsigned()->default(0);
            $table->smallInteger('realisasi_01')->unsigned()->default(0);
            $table->smallInteger('realisasi_02')->unsigned()->default(0);
            $table->smallInteger('realisasi_03')->unsigned()->default(0);
            $table->smallInteger('realisasi_04')->unsigned()->default(0);
            $table->smallInteger('realisasi_05')->unsigned()->default(0);
            $table->smallInteger('realisasi_06')->unsigned()->default(0);
            $table->smallInteger('realisasi_07')->unsigned()->default(0);
            $table->smallInteger('realisasi_08')->unsigned()->default(0);
            $table->smallInteger('realisasi_09')->unsigned()->default(0);
            $table->smallInteger('realisasi_10')->unsigned()->default(0);
            $table->smallInteger('realisasi_11')->unsigned()->default(0);
            $table->smallInteger('realisasi_12')->unsigned()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['tahun', 'seksi_id', 'kegiatan_id','kegiatan_tahapan_id' ], 'unique_kinerja_seksi');
            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('kegiatan_tahapan_id')->references('id')->on('siap_kerja_kegiatan_tahapan');
            $table->engine = 'InnoDB';
        });

        Schema::create('siap_kerja_capaian_individu', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('nip_lama', 10)->nullable();
            $table->string('mitra_id', 36)->nullable();
            $table->string('seksi_id', 3)->nullable();
            $table->string('kegiatan_id', 36);
            $table->string('kegiatan_tahapan_id', 36);
            $table->smallInteger('target_all')->unsigned();
            $table->string('tujuan', 100);
            $table->string('is_mulai', 1); // 1=> 1 mulai 0 tidak mulai
            $table->string('yang_isi', 1); //  2=> 0 seksi yang isi 1 indiviu yang is 
            $table->string('status_user', 1); // 0=> pegawai 1=>mitra
            $table->tinyInteger('bulan_awal')->unsigned();
            $table->tinyInteger('bulan_akhir')->unsigned();
            $table->string('tahun', 4);
            $table->string('capaian_tahapan_id',36)->nullable();
            $table->smallInteger('target_01')->unsigned()->default(0);
            $table->smallInteger('target_02')->unsigned()->default(0);
            $table->smallInteger('target_03')->unsigned()->default(0);
            $table->smallInteger('target_04')->unsigned()->default(0);
            $table->smallInteger('target_05')->unsigned()->default(0);
            $table->smallInteger('target_06')->unsigned()->default(0);
            $table->smallInteger('target_07')->unsigned()->default(0);
            $table->smallInteger('target_08')->unsigned()->default(0);
            $table->smallInteger('target_09')->unsigned()->default(0);
            $table->smallInteger('target_10')->unsigned()->default(0);
            $table->smallInteger('target_11')->unsigned()->default(0);
            $table->smallInteger('target_12')->unsigned()->default(0);
            $table->smallInteger('realisasi_01')->unsigned()->default(0);
            $table->smallInteger('realisasi_02')->unsigned()->default(0);
            $table->smallInteger('realisasi_03')->unsigned()->default(0);
            $table->smallInteger('realisasi_04')->unsigned()->default(0);
            $table->smallInteger('realisasi_05')->unsigned()->default(0);
            $table->smallInteger('realisasi_06')->unsigned()->default(0);
            $table->smallInteger('realisasi_07')->unsigned()->default(0);
            $table->smallInteger('realisasi_08')->unsigned()->default(0);
            $table->smallInteger('realisasi_09')->unsigned()->default(0);
            $table->smallInteger('realisasi_10')->unsigned()->default(0);
            $table->smallInteger('realisasi_11')->unsigned()->default(0);
            $table->smallInteger('realisasi_12')->unsigned()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['tahun', 'nip_lama', 'mitra_id', 'kegiatan_id','kegiatan_tahapan_id' ], 'unique_kinerja_individu');
            $table->foreign('kegiatan_id')->references('id')->on('siap_kerja_kegiatan');
            $table->foreign('seksi_id')->references('id')->on('seksi');
            $table->foreign('kegiatan_tahapan_id')->references('id')->on('siap_kerja_kegiatan_tahapan');
            $table->foreign('capaian_tahapan_id')->references('id')->on('siap_kerja_capaian_tahapan');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_ckp', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('nip_lama', 10);
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->string('status', 1); // 0: submit target 1: submit realisasi
            $table->string('ttd_t_nip_lama', 10)->nullable();
            $table->string('ttd_r_nip_lama', 10)->nullable();
            $table->date('ckp_t_ttd')->nullable();
            $table->date('ckp_r_ttd')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['nip_lama', 'bulan', 'tahun']);
            $table->foreign('nip_lama')->references('nip_lama')->on('users');
            $table->foreign('ttd_t_nip_lama')->references('nip_lama')->on('users');
            $table->foreign('ttd_r_nip_lama')->references('nip_lama')->on('users');
            $table->engine = 'InnoDB';
        });
        Schema::create('siap_kerja_ckp_item', function (Blueprint $table) {
            $table->string('id',36)->primary();
            $table->string('ckp_id', 36)->nullable();
            $table->string('capaian_individu_id', 36)->nullable();
            $table->string('nama', 255);
            $table->string('satuan', 20);
            $table->smallInteger('target')->unsigned()->default(0);
            $table->smallInteger('realisasi')->unsigned()->default(0);
            $table->string('is_delete', 1); // 0: submit target 1: submit realisasi
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('ckp_id')->references('id')->on('siap_kerja_ckp');
            $table->foreign('capaian_individu_id')->references('id')->on('siap_kerja_capaian_individu');
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
        Schema::dropIfExists('siap_kerja_CKP');
        Schema::dropIfExists('siap_kerja_capaian_individu');
        Schema::dropIfExists('siap_kerja_capaian_seksi');
        Schema::dropIfExists('siap_kerja_DL');
        Schema::dropIfExists('siap_kerja_kegiatan_tahapan_alokasi_dl');
        Schema::dropIfExists('siap_kerja_kegiatan_tahapan');
        Schema::dropIfExists('siap_kerja_kegiatan_pj');
        Schema::dropIfExists('siap_kerja_kegiatan');
        Schema::dropIfExists('siap_kerja_ref_kegiatan_tahapan');
    }
}
