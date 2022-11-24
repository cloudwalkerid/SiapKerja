<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tahapan_Alokasi_DL extends Model
{
    protected $table = 'siap_kerja_kegiatan_tahapan_alokasi_dl';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'nip_lama', 'seksi_id', 'is_mulai',  'status_spd', 'kegiatan_id', 'kegiatan_tahapan_id', 'jumlah_dl'
        , 'real_jumlah_dl', 'awal', 'akhir', 'tahun'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'nip_lama', 'nip_lama');
    }

    public function kegiatan()
    {
        return $this->hasOne('App\Models\Kegiatan', 'id', 'kegiatan_id');
    }

    public function kegiatanTahapan()
    {
        return $this->hasOne('App\Models\Kegiatan_Tahapan', 'id', 'kegiatan_tahapan_id');
    }

    public function DL()
    {
        return $this->hasMany('App\Models\DL', 'kegiatan_tahapan_alokasi_dl_id', 'id');
    }
}