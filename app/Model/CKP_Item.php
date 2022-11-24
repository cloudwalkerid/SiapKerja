<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CKP_Item extends Model
{
    protected $table = 'siap_kerja_ckp_item';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'ckp_id', 'capaian_individu_id','nama', 'satuan', 'target', 'realisasi', 'is_delete'];

    protected $appends = ['capaian', 'capaian_tulis'];

    public function ckp()
    {
        return $this->hasOne('App\Model\CKP', 'id', 'ckp_id');
    }

    public function capaianIndividu()
    {
        return $this->hasOne('App\Model\Capaian_Individu', 'id', 'capaian_individu_id');
    }
    public function getCapaianAttribute($value)
    {
        if($this->target == 0){
            if($this->realisasi == 0){
                return 0;
            }else{
                return 100;
            }
        }else{
            if((($this->realisasi/$this->target)*100)>120){
                return 120;
            }else{
                return (($this->realisasi/$this->target)*100);
            }
        }
    }
    public function getCapaianTulisAttribute($value)
    {
        if($this->target == 0){
            if($this->realisasi == 0){
                return number_format(0.00, 2, ',', ' ');
            }else{
                return number_format(100.00, 2, ',', ' ');
            }
        }else{
            if((($this->realisasi/$this->target)*100)>120){
                return number_format(120.00, 2, ',', ' ');
            }else{
                return number_format((($this->realisasi/$this->target)*100), 2, ',', ' ');
            }
        }
    }
}