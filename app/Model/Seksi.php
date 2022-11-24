<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    protected $table = 'seksi';
    protected $fillable = ['id','nama'];
    protected $keyType = 'string';
    public $timestamps = true;

    public function anggota()
    {
        return $this->hasMany('App\Model\User');
    }

    public function kegiatan()
    {
        return $this->hasMany('App\Model\Kegiatan', 'seksi_id', 'id');
    }
}