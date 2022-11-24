<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $fillable = ['id', 'nama'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}