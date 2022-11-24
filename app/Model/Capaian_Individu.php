<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Capaian_Individu extends Model
{
    protected $table = 'siap_kerja_capaian_individu';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    
    protected $fillable = ['id', 'nip_lama', 'mitra_id', 'seksi_id', 'kegiatan_id', 'kegiatan_tahapan_id'
        , 'target_all','tujuan', 'is_mulai', 'yang_isi', 'status_user', 'bulan_awal', 'bulan_akhir', 'tahun', 'capaian_tahapan_id'
        , 'target_01', 'target_02', 'target_03', 'target_04', 'target_05', 'target_06'
        , 'target_07', 'target_08', 'target_09', 'target_10', 'target_11', 'target_12'
        , 'realisasi_01', 'realisasi_02', 'realisasi_03', 'realisasi_04', 'realisasi_05', 'realisasi_06'
        , 'realisasi_07', 'realisasi_08', 'realisasi_09', 'realisasi_10', 'realisasi_11', 'realisasi_12'];

    // protected $appends = ['target_komulatif_01', 'target_komulatif_02', 'target_komulatif_03', 'target_komulatif_04', 'target_komulatif_05', 'target_komulatif_06'
    //     , 'target_komulatif_07', 'target_komulatif_08', 'target_komulatif_09', 'target_komulatif_10', 'target_komulatif_11', 'target_komulatif_12'
    //     , 'realisasi_komulatif_01', 'realisasi_komulatif_02', 'realisasi_komulatif_03', 'realisasi_komulatif_04', 'realisasi_komulatif_05', 'realisasi_komulatif_06'
    //     , 'realisasi_komulatif_07', 'realisasi_komulatif_08', 'realisasi_komulatif_09', 'realisasi_komulatif_10', 'realisasi_komulatif_11', 'realisasi_komulatif_12'
    //     , 'capaian_komulatif_01', 'capaian_komulatif_02', 'capaian_komulatif_03', 'capaian_komulatif_04', 'capaian_komulatif_05', 'capaian_komulatif_06'
    //     , 'capaian_komulatif_07', 'capaian_komulatif_08', 'capaian_komulatif_09', 'capaian_komulatif_10', 'capaian_komulatif_11', 'capaian_komulatif_12'];
    
    protected $appends = ['capaian_komulatif_01', 'capaian_komulatif_02', 'capaian_komulatif_03', 'capaian_komulatif_04', 'capaian_komulatif_05', 'capaian_komulatif_06'
        , 'capaian_komulatif_07', 'capaian_komulatif_08', 'capaian_komulatif_09', 'capaian_komulatif_10', 'capaian_komulatif_11', 'capaian_komulatif_12', 'capaian_komulatif_all'];

    public function user()
    {
        return $this->hasOne('App\Model\User', 'nip_lama', 'nip_lama');
    }

    public function mitra()
    {
        return $this->hasOne('App\Model\Mitra', 'id', 'mitra_id');
    }
    
    public function kegiatan()
    {
        return $this->hasOne('App\Model\Kegiatan', 'id', 'kegiatan_id');
    }

    public function kegiatanTahapan()
    {
        return $this->hasOne('App\Model\Kegiatan_Tahapan', 'id', 'kegiatan_tahapan_id');
    }

    public function capaianTahapan()
    {
        return $this->hasOne('App\Model\Capaian_Tahapan', 'id', 'capaian_tahapan_id');
    }

    public function DL()
    {
        return $this->hasOne('App\Model\DL', 'id', 'id');
    }

    public function getTargetKomulatif01Attribute($value)
    {
        if($this->bulan_awal> 1 || 1>$this->bulan_akhir){
            return null;
        }
        return $this->target_01;
    }
    public function getTargetKomulatif02Attribute($value)
    {
        if($this->bulan_awal> 2 || 2>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02;
    }
    public function getTargetKomulatif03Attribute($value)
    {
        if($this->bulan_awal> 3 || 3>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03;
    }
    public function getTargetKomulatif04Attribute($value)
    {
        if($this->bulan_awal> 4 || 4>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04;
    }
    public function getTargetKomulatif05Attribute($value)
    {
        if($this->bulan_awal> 5 || 5>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05;
    }
    public function getTargetKomulatif06Attribute($value)
    {
        if($this->bulan_awal> 6 || 6>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06;
    }
    public function getTargetKomulatif07Attribute($value)
    {
        if($this->bulan_awal> 7 || 7>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07;
    }
    public function getTargetKomulatif08Attribute($value)
    {
        if($this->bulan_awal> 8 || 8>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08;
    }
    public function getTargetKomulatif09Attribute($value)
    {
        if($this->bulan_awal> 9 || 9>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08+ $this->target_09;
    }
    public function getTargetKomulatif10Attribute($value)
    {
        if($this->bulan_awal> 10 || 10>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10;
    }
    public function getTargetKomulatif11Attribute($value)
    {
        if($this->bulan_awal> 11 || 11>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10 + $this->target_11;
    }
    public function getTargetKomulatif12Attribute($value)
    {
        if($this->bulan_awal> 12 || 12>$this->bulan_akhir){
            return null;
        }
        return $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10 + $this->target_11 + $this->target_12;
    }
    public function getRealisasiKomulatif01Attribute($value)
    {
        if($this->bulan_awal> 1 || 1>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01;
    }
    public function getRealisasiKomulatif02Attribute($value)
    {
        if($this->bulan_awal> 2 || 2>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02;
    }
    public function getRealisasiKomulatif03Attribute($value)
    {
        if($this->bulan_awal> 3 || 3>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03;
    }
    public function getRealisasiKomulatif04Attribute($value)
    {
        if($this->bulan_awal> 4 || 4>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04;
    }
    public function getRealisasiKomulatif05Attribute($value)
    {
        if($this->bulan_awal> 5 || 5>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05;
    }
    public function getRealisasiKomulatif06Attribute($value)
    {
        if($this->bulan_awal> 6 || 6>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06;
    }
    public function getRealisasiKomulatif07Attribute($value)
    {
        if($this->bulan_awal> 7 || 7>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07;
    }
    public function getRealisasiKomulatif08Attribute($value)
    {
        if($this->bulan_awal> 8 || 8>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08;
    }
    public function getRealisasiKomulatif09Attribute($value)
    {
        if($this->bulan_awal> 9 || 9>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08 + $this->realisasi_09;
    }
    public function getRealisasiKomulatif10Attribute($value)
    {
        if($this->bulan_awal> 10 || 10>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08 + $this->realisasi_09 + $this->realisasi_10;
    }
    public function getRealisasiKomulatif11Attribute($value)
    {
        if($this->bulan_awal> 11 || 11>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08 + $this->realisasi_09 + $this->realisasi_10 + $this->realisasi_11;
    }
    public function getRealisasiKomulatif12Attribute($value)
    {
        if($this->bulan_awal> 12 || 12>$this->bulan_akhir){
            return null;
        }
        return $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08+ $this->realisasi_09 + $this->realisasi_10 + $this->realisasi_11 + $this->realisasi_12;
    }

    public function getCapaianKomulatif01Attribute($value)
    {
        if($this->bulan_awal> 1 || 1>$this->bulan_akhir){
            return null;
        }
        $target_kw = $this->target_01;
        $realisasi_kw = $this->realisasi_01;
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif02Attribute($value)
    {
        if($this->bulan_awal> 2 || 2>$this->bulan_akhir){
            return null;
        }
        $sisa_target = $this->target_01 - $this->realisasi_01;
        $target_kw = $this->target_02 + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw =  $this->realisasi_02 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif03Attribute($value)
    {
        if($this->bulan_awal> 3 || 3>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02) - ($this->realisasi_01 + $this->realisasi_02);
        $target_kw = $this->target_03 + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_03  - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif04Attribute($value)
    {
        if($this->bulan_awal> 4 || 4>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03) 
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03);
        $target_kw = $this->target_04  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_04  - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif05Attribute($value)
    {
        if($this->bulan_awal> 5 || 5>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04);
        $target_kw = $this->target_05  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_05 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif06Attribute($value)
    {
        if($this->bulan_awal> 6 || 6>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05);
        $target_kw = $this->target_06  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_06 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif07Attribute($value)
    {
        if($this->bulan_awal> 7 || 7>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06);
        $target_kw = $this->target_07 + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_07 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif08Attribute($value)
    {
        if($this->bulan_awal> 8 || 8>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 + $this->target_07)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 + $this->realisasi_07);
        $target_kw = $this->target_08  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw =  $this->realisasi_08 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif09Attribute($value)
    {
        if($this->bulan_awal> 9 || 9>$this->bulan_akhir){
            return null;
        }
        $sisa_target =  ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 + $this->target_07 + $this->target_08)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 + $this->realisasi_07 + $this->realisasi_08);
        $target_kw = $this->target_09 + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_09 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif10Attribute($value)
    {
        if($this->bulan_awal> 10 || 10>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 + $this->target_07 + $this->target_08+ $this->target_09)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 + $this->realisasi_07 + $this->realisasi_08+ $this->realisasi_09);
        $target_kw = $this->target_10  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw =  $this->realisasi_10  - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif11Attribute($value)
    {
        if($this->bulan_awal> 11 || 11>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ( $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10)
            - ($this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 + $this->realisasi_07 + $this->realisasi_08+ $this->realisasi_09 + $this->realisasi_10);
        $target_kw = $this->target_11  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw =  $this->realisasi_11  - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatif12Attribute($value)
    {
        if($this->bulan_awal> 12 || 12>$this->bulan_akhir){
            return null;
        }
        $sisa_target = ($this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10 + $this->target_11)
            - ( $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 + $this->realisasi_07 + $this->realisasi_08+ $this->realisasi_09 + $this->realisasi_10 + $this->realisasi_11 );
        $target_kw = $this->target_12  + ($sisa_target>0 ? $sisa_target : 0);
        $realisasi_kw = $this->realisasi_12 - ($sisa_target<0 ? $sisa_target : 0);
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
    public function getCapaianKomulatifAllAttribute($value)
    {
        $target_kw = $this->target_01 + $this->target_02 + $this->target_03 + $this->target_04 + $this->target_05 + $this->target_06 
            + $this->target_07 + $this->target_08+ $this->target_09 + $this->target_10 + $this->target_11 + $this->target_12;
        $realisasi_kw = $this->realisasi_01 + $this->realisasi_02 + $this->realisasi_03 + $this->realisasi_04 + $this->realisasi_05 + $this->realisasi_06 
            + $this->realisasi_07 + $this->realisasi_08+ $this->realisasi_09 + $this->realisasi_10 + $this->realisasi_11 + $this->realisasi_12;
        if($target_kw == 0 || $realisasi_kw <= 0){
            return 0;
        }if((($realisasi_kw/$target_kw)*100)>120){
            return 120;
        }else{
            return (($realisasi_kw/$target_kw)*100);
        }
    }
}