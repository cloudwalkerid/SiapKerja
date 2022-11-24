<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ref_Kegiatan extends Model
{
    protected $table = 'siap_kerja_ref_kegiatan_tahapan';
    protected $fillable = ['ref_kode', 'nama', 'bobot'];
}