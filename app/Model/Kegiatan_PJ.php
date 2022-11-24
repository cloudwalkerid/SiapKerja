<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kegiatan_PJ extends Model
{
    protected $table = 'siap_kerja_kegiatan_pj';
    protected $fillable = [ 'id', 'kegiatan_id', 'nip_lama'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    public function kegiatan()
    {
        return $this->hasOne('App\Model\Kegiatan', 'id', 'kegiatan_id');
    }
    public function user()
    {
        return $this->hasOne('App\Model\User', 'nip_lama', 'nip_lama');
    }
}