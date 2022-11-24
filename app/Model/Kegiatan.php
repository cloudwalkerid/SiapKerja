<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{

    protected $table = 'siap_kerja_kegiatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = ['id', 'seksi_id', 'nama', 'anggaran', 'tahun'
        , 'capaian_01', 'capaian_02', 'capaian_03', 'capaian_04', 'capaian_05', 'capaian_06'
        , 'capaian_07', 'capaian_08', 'capaian_09', 'capaian_10', 'capaian_11', 'capaian_12', 'capaian_total'];

    public function kegiatanTahapan()
    {
        return $this->hasMany('App\Model\Kegiatan_Tahapan', 'kegiatan_id', 'id')->orderBy('created_at', 'asc');
    }

    public function kegiatanTahapanMulai()
    {
        return $this->hasMany('App\Model\Kegiatan_Tahapan', 'kegiatan_id', 'id')->where('is_mulai','1')->orderBy('created_at', 'asc');
    }

    public function pj()
    {
        return $this->hasMany('App\Model\Kegiatan_PJ','kegiatan_id', 'id');
    }

    public function capaianTahapan()
    {
        return $this->hasMany('App\Model\Capaian_Tahapan','kegiatan_id', 'id');
    }

    public function capaianIndividu()
    {
        return $this->hasMany('App\Model\Capaian_Individu','kegiatan_id', 'id');
    }

}