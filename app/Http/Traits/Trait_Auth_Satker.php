<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use App\Model\Ref_Kegiatan;

trait Trait_Auth_Satker {

    public $kepala = array('030');

    public function authIsKepala()
    {
        $iskepala = false;
        foreach($this->kepala as $itemKepala){
            if($itemKepala == auth()->user()->seksi_id){
                $iskepala = true;
            }
        }
        if( $iskepala && auth()->user()->is_kasi_plt == "1"){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function authCanTahapan($id_seksi_kegiatan)
    {
        $iskepala = false;
        foreach($this->kepala as $itemKepala){
            if($itemKepala == auth()->user()->seksi_id){
                $iskepala = true;
            }
        }
        if( $iskepala || (auth()->user()->seksi_id ==  $id_seksi_kegiatan 
            && (auth()->user()->is_kasi_plt == "1" || auth()->user()->is_kasi_plt == "2"))){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function authCanCapaian($id_seksi_kegiatan)
    {
        $iskepala = false;
        foreach($this->kepala as $itemKepala){
            if($itemKepala == auth()->user()->seksi_id){
                $iskepala = true;
            }
        }
        if( $iskepala && auth()->user()->seksi_id ==  $id_seksi_kegiatan && auth()->user()->is_kasi_plt == "1"){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}