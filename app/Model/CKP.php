<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CKP extends Model
{
    protected $table = 'siap_kerja_ckp';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'nip_lama','bulan', 'tahun', 'status', 'ttd_t_nip_lama', 'ttd_r_nip_lama', 'ckp_t_ttd ', 'ckp_r_ttd'];
    protected $appends = ['rentang'];

    public function user()
    {
        return $this->hasOne('App\Model\User', 'nip_lama', 'nip_lama');
    }
    public function ttd_t()
    {
        return $this->hasOne('App\Model\User', 'nip_lama', 'ttd_t_nip_lama');
    }
    public function ttd_r()
    {
        return $this->hasOne('App\Model\User', 'nip_lama', 'ttd_r_nip_lama');
    }
    public function ckpItem()
    {
        return $this->hasMany('App\Model\CKP_Item', 'ckp_id', 'id')->where('is_delete','0')->orderBy('created_at', 'asc');
    }
    public function ckpItemNotFull()
    {
        return $this->hasMany('App\Model\CKP_Item', 'ckp_id', 'id')->where('is_delete','0')->where('target','>','realisasi');
    }
    public function getCkpTTtdAttribute($value)
    {
        $date_k = strtotime($value);
        return  date('d-m-Y', $date_k);
    }

    public function getCkpRTtdAttribute($value)
    {
        $date_k = strtotime($value);
        return  date('d-m-Y', $date_k);
    }
    public function getRentangAttribute($value)
    {
        if($this->bulan == '01'){
            return '1 - 31 Januari '.env('TAHUN', '2020');
        }else if($this->bulan == '02'){
            $hasil = intval(env('TAHUN', '2020'))%4;
            if($hasil == 0){
                return '1 - 29 Februari '.env('TAHUN', '2020');
            }else{
                return '1 - 28 Februari '.env('TAHUN', '2020');
            }
        }else if($this->bulan == '03'){
            return '1 - 31 Maret '.env('TAHUN', '2020');
        }else if($this->bulan == '04'){
            return '1 - 30 April '.env('TAHUN', '2020');
        }else if($this->bulan == '05'){
            return '1 - 31 Mei '.env('TAHUN', '2020');
        }else if($this->bulan == '06'){
            return '1 - 30 Juni '.env('TAHUN', '2020');
        }else if($this->bulan == '07'){
            return '1 - 31 Juli '.env('TAHUN', '2020');
        }else if($this->bulan == '08'){
            return '1 - 31 Agustus '.env('TAHUN', '2020');
        }else if($this->bulan == '09'){
            return '1 - 30 September '.env('TAHUN', '2020');
        }else if($this->bulan == '10'){
            return '1 - 31 Oktober '.env('TAHUN', '2020');
        }else if($this->bulan == '11'){
            return '1 - 30 November '.env('TAHUN', '2020');
        }else if($this->bulan == '12'){
            return '1 - 31 Desember '.env('TAHUN', '2020');
        }
    }
}