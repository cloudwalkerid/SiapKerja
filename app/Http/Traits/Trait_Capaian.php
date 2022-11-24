<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Log;

use App\Model\Kegiatan;
use App\Model\Kegiatan_PJ;
use App\Model\Kegiatan_Tahapan;
use App\Model\Capaian_Tahapan;
use App\Model\Capaian_Individu;
use App\Http\Traits\Trait_Auth_Satker;

trait Trait_Capaian {

    use Trait_Auth_Satker;

    public function getBeranda(Request $request)
    {
        $kegiatan = Kegiatan::where("tahun", env('TAHUN', '2020'))->get();
        return $kegiatan;
    }

    public function getSeksi(Request $request)
    {
        if($this->authIsKepala()){
            $kegiatan = Kegiatan::with(["kegiatanTahapan", "PJ"])
                ->where("tahun", env('TAHUN', '2020'))
                ->get();
            return $kegiatan;
        }else{
            $kegiatan = Kegiatan::with(["kegiatanTahapan", "PJ"])
                ->where("tahun", env('TAHUN', '2020'))
                ->where("seksi_id", auth()->user()->seksi_id)
                ->get();
            return $kegiatan;
        }
    }

    public function getIndividu(Request $request)
    {
        $all_kegiatan = [];
        if($this->authIsKepala()){
           
            $all_kegiatan_a = Kegiatan::where("tahun", env('TAHUN', '2020'))->get();
            foreach($all_kegiatan_a as $itemKegiatan){
                array_push($all_kegiatan, $itemKegiatan->id);
            }
        }else{
            if(auth()->user()->is_kasi_plt == "1" || auth()->user()->is_kasi_plt == "2"){
                $kasi_kegiatan = Kegiatan::where("seksi_id",auth()->user()->seksi_id)
                    ->where("tahun", env('TAHUN', '2020'))
                    ->get();
                foreach($kasi_kegiatan as $itemKeg){
                    array_push($all_kegiatan, $itemKeg->id);
                }
            }
            $kegiatanAsPjs = Kegiatan_PJ::where("nip_lama",auth()->user()->nip_lama)
                ->get();
            $kegiatanAsPjs = $kegiatanAsPjs;
            foreach ($kegiatanAsPjs as $itemkegiatanAsPj){
                $baru = TRUE;
                foreach ($all_kegiatan as $item){
                    if($itemkegiatanAsPj->kegiatan_id == $item){
                        $baru = FALSE;
                        break;
                    }
                }
                if($baru){
                    array_push($all_kegiatan, $itemkegiatanAsPj->kegiatan_id);
                }
            }
        }
        $kegiatan = Kegiatan::with(["kegiatanTahapanMulai.capaianTahapan.capaianIndividu.user", "kegiatanTahapanMulai.capaianTahapan.capaianIndividu.mitra"])
            ->whereIn("id", $all_kegiatan)
            ->where("tahun", env('TAHUN', '2020'))
            ->get();
        $capaian_individu = Capaian_Individu::with(["kegiatan", "kegiatanTahapan"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("is_mulai", '1')
            ->where("tahun", env('TAHUN', '2020'))
            ->get();
        
        $hasil = [];
        $hasil['kegiatan'] =  $kegiatan;
        $hasil['individu'] =  $capaian_individu;
        return $hasil;
    }

    public function getOnlyYou(Request $request)
    {
        $capaian_individu = Capaian_Individu::with(["kegiatan", "kegiatanTahapan"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("is_mulai", '1')
            ->where("tahun", env('TAHUN', '2020'))
            ->get();
        return $capaian_individu;
    }

    public function updateCapaianSeksi(Request $request, $idCapaianSeksi)
    {
        $capaian_tahapan = Capaian_Tahapan::with("kegiatan.PJ")
            ->where("id", $idCapaianSeksi)->where("is_mulai", '1')
            ->first();
        if($this->authCanTahapan($capaian_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->updateCapaianSeksi_helper($request, $capaian_tahapan);
                $this->updateAlokasidanCapaian($request, $capaian_tahapan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($capaian_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->updateCapaianSeksi_helper($request, $capaian_tahapan);
                    $this->updateAlokasidanCapaian($request, $capaian_tahapan);
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }
    public function updateCapaianSeksi_helper(Request $request, Capaian_Tahapan $capaian_tahapan)
    {
        //realisasi
        $capaian_tahapan->realisasi_01 = $request->realisasi_01;
        $capaian_tahapan->realisasi_02 = $request->realisasi_02;
        $capaian_tahapan->realisasi_03 = $request->realisasi_03;
        $capaian_tahapan->realisasi_04 = $request->realisasi_04;
        $capaian_tahapan->realisasi_05 = $request->realisasi_05;
        $capaian_tahapan->realisasi_06 = $request->realisasi_06;
        $capaian_tahapan->realisasi_07 = $request->realisasi_07;
        $capaian_tahapan->realisasi_08 = $request->realisasi_08;
        $capaian_tahapan->realisasi_09 = $request->realisasi_09;
        $capaian_tahapan->realisasi_10 = $request->realisasi_10;
        $capaian_tahapan->realisasi_11 = $request->realisasi_11;
        $capaian_tahapan->realisasi_12 = $request->realisasi_12;
        $capaian_tahapan->save();
    }

    public function updateCapaianIndividu(Request $request, $idCapaianIndividu)
    {
        $capaian_individu = Capaian_Individu::with(["kegiatan.PJ", "capaianTahapan"])
            ->where("id", $idCapaianIndividu)
            ->where("is_mulai", '1')
            ->first();
        if($this->authCanTahapan($capaian_individu->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->updateCapaianIndividu_helper($request, $capaian_individu);
                $this->updateAlokasidanCapaian($request, $capaian_individu->capaianTahapan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else if($capaian_individu->nip_lama == auth()->user()->nip_lama){
            DB::beginTransaction();
            try{
                $this->updateCapaianIndividu_helper($request, $capaian_individu);
                $this->updateAlokasidanCapaian($request, $capaian_individu->capaianTahapan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($capaian_individu->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->updateCapaianIndividu_helper($request, $capaian_individu);
                    $this->updateAlokasidanCapaian($request, $capaian_individu->capaianTahapan);
                    DB::commit();
                    return 1;
                }catch(Exception $e){
                    DB::rollBack();
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }

    public function updateCapaianIndividu_helper(Request $request, Capaian_Individu $capaian_individu)
    {
        $capaian_tahapan = $capaian_individu->capaianTahapan;
        $capaian_tahapan->realisasi_01 = $capaian_tahapan->realisasi_01 - $capaian_individu->realisasi_01 + $request->realisasi_01;
        $capaian_tahapan->realisasi_02 = $capaian_tahapan->realisasi_02 - $capaian_individu->realisasi_02 + $request->realisasi_02;
        $capaian_tahapan->realisasi_03 = $capaian_tahapan->realisasi_03 - $capaian_individu->realisasi_03 + $request->realisasi_03;
        $capaian_tahapan->realisasi_04 = $capaian_tahapan->realisasi_04 - $capaian_individu->realisasi_04 + $request->realisasi_04;
        $capaian_tahapan->realisasi_05 = $capaian_tahapan->realisasi_05 - $capaian_individu->realisasi_05 + $request->realisasi_05;
        $capaian_tahapan->realisasi_06 = $capaian_tahapan->realisasi_06 - $capaian_individu->realisasi_06 + $request->realisasi_06;
        $capaian_tahapan->realisasi_07 = $capaian_tahapan->realisasi_07 - $capaian_individu->realisasi_07 + $request->realisasi_07;
        $capaian_tahapan->realisasi_08 = $capaian_tahapan->realisasi_08 - $capaian_individu->realisasi_08 + $request->realisasi_08;
        $capaian_tahapan->realisasi_09 = $capaian_tahapan->realisasi_09 - $capaian_individu->realisasi_09 + $request->realisasi_09;
        $capaian_tahapan->realisasi_10 = $capaian_tahapan->realisasi_10 - $capaian_individu->realisasi_10 + $request->realisasi_10;
        $capaian_tahapan->realisasi_11 = $capaian_tahapan->realisasi_11 - $capaian_individu->realisasi_11 + $request->realisasi_11;
        $capaian_tahapan->realisasi_12 = $capaian_tahapan->realisasi_12 - $capaian_individu->realisasi_12 + $request->realisasi_12;

        $capaian_individu->realisasi_01 = $request->realisasi_01;
        $capaian_individu->realisasi_02 = $request->realisasi_02;
        $capaian_individu->realisasi_03 = $request->realisasi_03;
        $capaian_individu->realisasi_04 = $request->realisasi_04;
        $capaian_individu->realisasi_05 = $request->realisasi_05;
        $capaian_individu->realisasi_06 = $request->realisasi_06;
        $capaian_individu->realisasi_07 = $request->realisasi_07;
        $capaian_individu->realisasi_08 = $request->realisasi_08;
        $capaian_individu->realisasi_09 = $request->realisasi_09;
        $capaian_individu->realisasi_10 = $request->realisasi_10;
        $capaian_individu->realisasi_11 = $request->realisasi_11;
        $capaian_individu->realisasi_12 = $request->realisasi_12;

        $capaian_individu->save();
        $capaian_tahapan->save();
    }

    public function updateBobotDanDeleteTahapan(Request $request, $idKegiatan)
    {
        //perubahan bobot saja dan deleteTahapan
        $kegiatan = Kegiatan::with("kegiatanTahapan")
            ->where("id", $idKegiatan)
            ->first();
        // Log::info($kegiatan);
        $bobot_01 = 0;
        $bobot_02 = 0;
        $bobot_03 = 0;
        $bobot_04 = 0;
        $bobot_05 = 0;
        $bobot_06 = 0;
        $bobot_07 = 0;
        $bobot_08 = 0;
        $bobot_09 = 0;
        $bobot_10 = 0;
        $bobot_11 = 0;
        $bobot_12 = 0;
        $bobot_total = 0;
        foreach($kegiatan->kegiatanTahapan as $itemTahapan){
            $bobot_total = $bobot_total + $itemTahapan->bobot_kegiatan_tahapan;
            if($itemTahapan->bobot_01>0 && $itemTahapan->capaian_01!=NULL){
                $bobot_01 = $bobot_01 + $itemTahapan->bobot_01;
            }
            if($itemTahapan->bobot_02>0 && $itemTahapan->capaian_02!=NULL){
                $bobot_02 = $bobot_02 + $itemTahapan->bobot_02;
            }
            if($itemTahapan->bobot_03>0 && $itemTahapan->capaian_03!=NULL){
                $bobot_03 = $bobot_03 + $itemTahapan->bobot_03;
            }
            if($itemTahapan->bobot_04>0 && $itemTahapan->capaian_04!=NULL){
                $bobot_04 = $bobot_04 + $itemTahapan->bobot_04;
            }
            if($itemTahapan->bobot_05>0 && $itemTahapan->capaian_05!=NULL){
                $bobot_05 = $bobot_05 + $itemTahapan->bobot_05;
            }
            if($itemTahapan->bobot_06>0 && $itemTahapan->capaian_06!=NULL){
                $bobot_06 = $bobot_06 + $itemTahapan->bobot_06;
            }
            if($itemTahapan->bobot_07>0 && $itemTahapan->capaian_07!=NULL){
                $bobot_07 = $bobot_07 + $itemTahapan->bobot_07;
            }
            if($itemTahapan->bobot_08>0 && $itemTahapan->capaian_08!=NULL){
                $bobot_08 = $bobot_08 + $itemTahapan->bobot_08;
            }
            if($itemTahapan->bobot_09>0 && $itemTahapan->capaian_09!=NULL){
                $bobot_09 = $bobot_09 + $itemTahapan->bobot_09;
            }
            if($itemTahapan->bobot_10>0 && $itemTahapan->capaian_10!=NULL){
                $bobot_10 = $bobot_10 + $itemTahapan->bobot_10;
            }
            if($itemTahapan->bobot_11>0 && $itemTahapan->capaian_11!=NULL){
                $bobot_11 = $bobot_11 + $itemTahapan->bobot_11;
            }
            if($itemTahapan->bobot_12>0 && $itemTahapan->capaian_12!=NULL){
                $bobot_12 = $bobot_12 + $itemTahapan->bobot_12;
            }
        }
        

        $capaian_01 = NULL;
        $capaian_02 = NULL;
        $capaian_03 = NULL;
        $capaian_04 = NULL;
        $capaian_05 = NULL;
        $capaian_06 = NULL;
        $capaian_07 = NULL;
        $capaian_08 = NULL;
        $capaian_09 = NULL;
        $capaian_10 = NULL;
        $capaian_11 = NULL;
        $capaian_12 = NULL;
        $capaian_total = 0;
        foreach($kegiatan->kegiatanTahapan as $itemTahapan){
            if($itemTahapan->bobot_01>0 && $itemTahapan->capaian_01!=NULL){
                $capaian_01 = $capaian_01 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_01) * $itemTahapan->capaian_01);
            }
            if($itemTahapan->bobot_02>0 && $itemTahapan->capaian_02!=NULL){
                $capaian_02 = $capaian_02 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_02) * $itemTahapan->capaian_02);
            }
            if($itemTahapan->bobot_03>0 && $itemTahapan->capaian_03!=NULL){
                $capaian_03 = $capaian_03 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_03) * $itemTahapan->capaian_03);
            }
            if($itemTahapan->bobot_04>0 && $itemTahapan->capaian_04!=NULL){
                $capaian_04 = $capaian_04 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_04) * $itemTahapan->capaian_04);
            }
            if($itemTahapan->bobot_05>0 && $itemTahapan->capaian_05!=NULL){
                $capaian_05 = $capaian_05 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_05) * $itemTahapan->capaian_05);
            }
            if($itemTahapan->bobot_06>0 && $itemTahapan->capaian_06!=NULL){
                $capaian_06 = $capaian_06 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_06) * $itemTahapan->capaian_06);
            }
            if($itemTahapan->bobot_07>0 && $itemTahapan->capaian_07!=NULL){
                $capaian_07 = $capaian_07 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_07) * $itemTahapan->capaian_07);
            }
            if($itemTahapan->bobot_08>0 && $itemTahapan->capaian_08!=NULL){
                $capaian_08 = $capaian_08 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_08) * $itemTahapan->capaian_08);
            }
            if($itemTahapan->bobot_09>0 && $itemTahapan->capaian_09!=NULL){
                $capaian_09 = $capaian_09 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_09) * $itemTahapan->capaian_09);
            }
            if($itemTahapan->bobot_10>0 && $itemTahapan->capaian_10!=NULL){
                $capaian_10 = $capaian_10 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_10) * $itemTahapan->capaian_10);
            }
            if($itemTahapan->bobot_11>0 && $itemTahapan->capaian_11!=NULL){
                $capaian_11 = $capaian_11 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_11) * $itemTahapan->capaian_11);
            }
            if($itemTahapan->bobot_12>0 && $itemTahapan->capaian_12!=NULL){
                $capaian_12 = $capaian_12 + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_12) * $itemTahapan->capaian_12);
            }
            if($itemTahapan->capaian_total!=NULL){
                $capaian_total = $capaian_total + (($itemTahapan->bobot_kegiatan_tahapan/$bobot_total) * $itemTahapan->capaian_total);
            }
        }
        $kegiatan->capaian_01 = $capaian_01;
        $kegiatan->capaian_02 = $capaian_02;
        $kegiatan->capaian_03 = $capaian_03;
        $kegiatan->capaian_04 = $capaian_04;
        $kegiatan->capaian_05 = $capaian_05;
        $kegiatan->capaian_06 = $capaian_06;
        $kegiatan->capaian_07 = $capaian_07;
        $kegiatan->capaian_08 = $capaian_08;
        $kegiatan->capaian_09 = $capaian_09;
        $kegiatan->capaian_10 = $capaian_10;
        $kegiatan->capaian_11 = $capaian_11;
        $kegiatan->capaian_12 = $capaian_12;
        $kegiatan->capaian_total = $capaian_total;
        $kegiatan->save();
    }

    public function updateAlokasidanCapaian(Request $request, $capaianTahapan)
    {
        // Log::info('123455');
        // Log::info($capaianTahapan->capaian_komulatif_01);
        // Log::info($capaianTahapan->capaian_komulatif_02);
        // Log::info($capaianTahapan->capaian_komulatif_all);
        // Log::info($capaianTahapan);
        Kegiatan_Tahapan::where("id",$capaianTahapan->kegiatan_tahapan_id)
            ->where("kegiatan_id",$capaianTahapan->kegiatan_id)
            ->update(['capaian_01' => $capaianTahapan->capaian_komulatif_01
                , 'capaian_02' => $capaianTahapan->capaian_komulatif_02
                , 'capaian_03' => $capaianTahapan->capaian_komulatif_03
                , 'capaian_04' => $capaianTahapan->capaian_komulatif_04
                , 'capaian_05' => $capaianTahapan->capaian_komulatif_05
                , 'capaian_06' => $capaianTahapan->capaian_komulatif_06
                , 'capaian_07' => $capaianTahapan->capaian_komulatif_07
                , 'capaian_08' => $capaianTahapan->capaian_komulatif_08
                , 'capaian_09' => $capaianTahapan->capaian_komulatif_09
                , 'capaian_10' => $capaianTahapan->capaian_komulatif_10
                , 'capaian_11' => $capaianTahapan->capaian_komulatif_11
                , 'capaian_12' => $capaianTahapan->capaian_komulatif_12
                , 'capaian_total' => $capaianTahapan->capaian_komulatif_all]);

        $this->updateBobotDanDeleteTahapan($request, $capaianTahapan->kegiatan_id);
    }
    // public function refresh_all_capaian(Request $request)
    // {
    //     echo auth()->user()->nip_lama;
    //     if(auth()->user()->nip_lama != '340058179'){
    //         return "";
    //     }else{
    //         DB::beginTransaction();
    //         try{
    //             $capain_tahapan_all = Capaian_Tahapan::all();

    //             foreach($capain_tahapan_all as $item){
    //                 $this->updateAlokasidanCapaian($request, $item);
    //             }
    //             DB::commit();
    //             return 1;
    //         }catch(Exception $e){
    //             DB::rollBack();
    //             return abort(500);
    //         }
            
    //     }
    // }
}