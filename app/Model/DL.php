<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DL extends Model
{
    protected $table = 'siap_kerja_dl';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'nip_lama', 'seksi_id', 'status_spd', 'kegiatan_id', 'kegiatan_tahapan_id'
        , 'kegiatan_tahapan_alokasi_dl_id', 'tanggal', 'bulan', 'tahun'];
    
    public function kegiatan()
    {
        return $this->hasOne('App\Model\Kegiatan', 'id', 'kegiatan_id');
    }

    public function kegiatanTahapan()
    {
        return $this->hasOne('App\Model\Kegiatan_Tahapan', 'id', 'kegiatan_tahapan_id');
    }

    public function tahapanAlokasi()
    {
        return $this->hasOne('App\Model\Tahapan_Alokasi_DL', 'id', 'kegiatan_tahapan_alokasi_dl_id');
    }
}