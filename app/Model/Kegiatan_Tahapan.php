<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kegiatan_Tahapan extends Model
{
    protected $table = 'siap_kerja_kegiatan_tahapan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'seksi_id', 'kegiatan_id', 'nama', 'satuan', 'target_all', 'ref_kode', 'bobot_kegiatan_tahapan'
            , 'awal', 'akhir', 'bulan_awal', 'bulan_akhir', 'is_mulai', 'yang_isi', 'status_spd', 'tahun'
            , 'capaian_01', 'capaian_02', 'capaian_03', 'capaian_04', 'capaian_05', 'capaian_06'
            , 'capaian_07', 'capaian_08', 'capaian_09', 'capaian_10', 'capaian_11', 'capaian_12', 'capaian_total'];
    
    public function getAwalAttribute($value)
    {
        $date_k = strtotime($value);
        return  date('d-m-Y', $date_k);
    }

    public function getAkhirAttribute($value)
    {
        $date_k = strtotime($value);
        return  date('d-m-Y', $date_k);
    }

    public function kegiatan()
    {
        return $this->hasOne('App\Model\Kegiatan', 'id', 'kegiatan_id');
    }

    public function alokasi_dl()
    {
        return $this->hasMany('App\Model\Tahapan_Alokasi_DL', 'kegiatan_tahapan_id', 'id');
    }

    public function capaianTahapan()
    {
        return $this->hasOne('App\Model\Capaian_Tahapan', 'kegiatan_tahapan_id', 'id');
    }

    public function capaianIndividu()
    {
        return $this->hasMany('App\Model\Capaian_Individu', 'kegiatan_tahapan_id', 'id');
    }

    public function refKegiatan()
    {
        return $this->hasOne('App\Model\Ref_Kegiatan', 'ref_kode', 'ref_kode');
    }

    public function getBobot01Attribute($value)
    {
        if($this->bulan_awal<= 1 && 1<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot02Attribute($value)
    {
        if($this->bulan_awal<=2  && 2<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot03Attribute($value)
    {
        if($this->bulan_awal<= 3 && 3<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot04Attribute($value)
    {
        if($this->bulan_awal<= 4 && 4<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot05Attribute($value)
    {
        if($this->bulan_awal<= 5 && 5<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot06Attribute($value)
    {
        if($this->bulan_awal<= 6 && 6<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot07Attribute($value)
    {
        if($this->bulan_awal<= 7 && 7<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot08Attribute($value)
    {
        if($this->bulan_awal<= 8 && 8<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot09Attribute($value)
    {
        if($this->bulan_awal<= 9 && 9<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot10Attribute($value)
    {
        if($this->bulan_awal<= 10 && 10<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot11Attribute($value)
    {
        if($this->bulan_awal<= 11 && 11<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
    public function getBobot12Attribute($value)
    {
        if($this->bulan_awal<= 12 && 12<=$this->bulan_akhir){
            return $this->bobot_kegiatan_tahapan;
        }else{
            return 0;
        }
    }
}