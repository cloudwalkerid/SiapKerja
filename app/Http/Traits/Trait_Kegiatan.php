<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use App\Model\Kegiatan;
use App\Model\Kegiatan_PJ;
use App\Model\Kegiatan_Tahapan;
use App\Model\Tahapan_Alokasi_DL;
use App\Model\Capaian_Tahapan;
use App\Model\Capaian_Individu;
use App\Model\Mitra;
use App\Model\DL;
use App\Model\Ref_Kegiatan;
use App\Http\Traits\Trait_Auth_Satker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use Illuminate\Support\Facades\Log;

trait Trait_Kegiatan {

    // use Trait_Update_Nilai;
    use Trait_Capaian;

    public function list_kegiatan(Request $request)
    {
        if($this->authIsKepala()){
            $all_kegiatan = [];
            $all_kegiatan = Kegiatan::where("tahun", env('TAHUN', '2020'))
                ->orderBy('created_at', 'asc')
                ->get();
            return $all_kegiatan;
        }else{
            $all_kegiatan = [];
            if(auth()->user()->is_kasi_plt == "1" || auth()->user()->is_kasi_plt == "2"){
                $kasi_kegiatan = Kegiatan::where("seksi_id",auth()->user()->seksi_id)
                    ->where("tahun", env('TAHUN', '2020'))
                    ->orderBy('created_at', 'asc')
                    ->get();
                $kasi_kegiatan = $kasi_kegiatan->toArray();
                $all_kegiatan = $kasi_kegiatan;
            }
            $kegiatanAsPjs = Kegiatan_PJ::with("kegiatan")
                ->where("nip_lama",auth()->user()->nip_lama)
                ->get(); 
            foreach ($kegiatanAsPjs as $itemkegiatanAsPj){
                $baru = TRUE;
                foreach ($all_kegiatan as $item){
                    if($itemkegiatanAsPj->kegiatan_id == $item['id']){
                        $baru = FALSE;
                        break;
                    }
                }
                if($baru){
                    array_push($all_kegiatan, $itemkegiatanAsPj->kegiatan);
                }
            }
            return $all_kegiatan;
        }
       
    }

    public function list_kegiatan_only_month(Request $request)
    {
        $month = date('m');
        if($this->authIsKepala()){
            $all_kegiatan = [];
            $all_kegiatan = Kegiatan::whereNotNull('capaian_'.sprintf('%02d', $month))
                ->where("tahun", env('TAHUN', '2020'))
                ->orderBy('created_at', 'asc')
                ->get();
            return $all_kegiatan;
        }else{
            $all_kegiatan = [];
            if(auth()->user()->is_kasi_plt == "1" || auth()->user()->is_kasi_plt == "2"){
                $kasi_kegiatan = Kegiatan::whereNotNull('capaian_'.sprintf('%02d', $month))
                    ->where("seksi_id",auth()->user()->seksi_id)
                    ->where("tahun", env('TAHUN', '2020'))
                    ->orderBy('created_at', 'asc')
                    ->get();
                $kasi_kegiatan = $kasi_kegiatan->toArray();
                $all_kegiatan = $kasi_kegiatan;
            }
            $kegiatanAsPjs = Kegiatan_PJ::with("kegiatan")
                ->where("nip_lama",auth()->user()->nip_lama)
                ->get(); 
            foreach ($kegiatanAsPjs as $itemkegiatanAsPj){
                $baru = TRUE;
                foreach ($all_kegiatan as $item){
                    if($itemkegiatanAsPj->kegiatan_id == $item['id']){
                        $baru = FALSE;
                        break;
                    }
                }
                if($baru){
                    array_push($all_kegiatan, $itemkegiatanAsPj->kegiatan);
                }
            }
            return $all_kegiatan;
        }
       
    }

    public function createKegiatan(Request $request)
    {
        if( auth()->user()->is_kasi_plt == "0"){
            return abort(403);
        }
        try{
            $kegiatanBarus = $this->createKegiatanHelper($request);
            return $kegiatanBarus->id;
        }catch(Exception $e){
            return abort(500);
        }
      
    }

    public function createKegiatanHelper(Request $request)
    {
        $uuid = (string) Uuid::generate();
        $kegiatanBarus = new Kegiatan();
        $kegiatanBarus->id = (string) Uuid::generate();
        $kegiatanBarus->seksi_id = auth()->user()->seksi_id;
        $kegiatanBarus->nama = $request->nama;
        $kegiatanBarus->anggaran = $request->anggaran;
        $kegiatanBarus->tahun = env('TAHUN', '2020');
        $kegiatanBarus->capaian_total = 0;
        $kegiatanBarus->save();
        return $kegiatanBarus;
    }

    public function updateKegiatan(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::with("PJ")
            ->where("id", $idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            try{
                $this->updateKegiatanHelper($request, $kegiatan);
                return '1';
            }catch(Exception $e){
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                try{
                    $this->updateKegiatanHelper($request, $kegiatan);
                    return '1';
                }catch(Exception $e){
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }

    public function updateKegiatanHelper(Request $request, Kegiatan $kegiatan)
    {
        $kegiatan->nama = $request->nama;
        $kegiatan->anggaran = $request->anggaran;
        $kegiatan->save();
    }

    public function deleteKegiatan(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::where("id", $idKegiatan)->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            try{
                $this->deleteKegiatanHelper($request, $kegiatan);
                return '1';
            }catch(Exception $e){
                return abort(500);
            }
        }else{
           
            return abort(403);
        }
    }

    public function deleteKegiatanHelper(Request $request, Kegiatan $kegiatan)
    {
        Capaian_Individu::where('kegiatan_id', $kegiatan->id)->delete();
        Capaian_Tahapan::where('kegiatan_id', $kegiatan->id)->delete();
        DL::where('kegiatan_id', $kegiatan->id)->delete();
        Tahapan_Alokasi_DL::where('kegiatan_id', $kegiatan->id)->delete();
        Kegiatan_Tahapan::where('kegiatan_id', $kegiatan->id)->delete();
        Kegiatan_PJ::where('kegiatan_id', $kegiatan->id)->delete();
        Kegiatan::where('id', $kegiatan->id)->delete();
    }


    public function Kegiatan_show(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::with(["PJ.user","kegiatanTahapan.capaianIndividu.user"])
            ->where("id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            return $kegiatan;
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                return $kegiatan;
            }else{
                return abort(403);
            }
        }
    }

    

    public function tahapanKegiatan_show(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with(["kegiatan.PJ", "capaianTahapan", "capaianIndividu", "alokasi_dl"])
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        $alluser = User::all();
        $allmitra = Mitra::all();
        $hasil = [];
        $hasil['kegiatan_tahapan'] = $kegiatan_tahapan;
        $hasil['alluser'] = $alluser;
        $hasil['allmitra'] = $allmitra;
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            return $hasil;
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                return $hasil;
            }else{
                return abort(403);
            }
        }
    }

    public function tahapanKegiatan_create(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::with("PJ")
            ->where("id",$idKegiatan)
            ->first();;
        if($this->authCanTahapan($kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $KegiatanTahapanBaru = $this->tahapanKegiatan_create_helper($request, $kegiatan);
                $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
                DB::commit();
                return $KegiatanTahapanBaru;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $KegiatanTahapanBaru = $this->tahapanKegiatan_create_helper($request, $kegiatan);
                    $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
                    DB::commit();
                    return $KegiatanTahapanBaru;
                }catch(Exception $e){
                    DB::rollBack();
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }

    public function tahapanKegiatan_create_helper(Request $request, Kegiatan $kegiatan)
    {
        $awal_array = explode('-', $request->awal);
        $akhir_array = explode('-', $request->akhir);

        $date_awal = $awal_array[2].'-'.$awal_array[1].'-'.$awal_array[0];
        $bulan_awal = $awal_array[1];

        $date_akhir = $akhir_array[2].'-'.$akhir_array[1].'-'.$akhir_array[0];
        $bulan_akhir = $akhir_array[1];

        $refKode = Ref_Kegiatan::where('ref_kode', $request->ref_kode)->first();;
        $KegiatanTahapanBaru = new Kegiatan_Tahapan;
        $KegiatanTahapanBaru->id = (string) Uuid::generate();
        $KegiatanTahapanBaru->seksi_id = $kegiatan->seksi_id;
        $KegiatanTahapanBaru->kegiatan_id = $kegiatan->id;
        $KegiatanTahapanBaru->nama = $request->nama;
        $KegiatanTahapanBaru->satuan = $request->satuan;
        $KegiatanTahapanBaru->target_all = 0;
        $KegiatanTahapanBaru->ref_kode = $request->ref_kode;
        if($this->authIsKepala()){
            if($request->bobot_kegiatan_tahapan==null){
                $KegiatanTahapanBaru->bobot_kegiatan_tahapan = $refKode->bobot;
            }else{
                $KegiatanTahapanBaru->bobot_kegiatan_tahapan = $request->bobot_kegiatan_tahapan;
            }
        }else{
            $KegiatanTahapanBaru->bobot_kegiatan_tahapan = $refKode->bobot;
        }
        $KegiatanTahapanBaru->awal =  $date_awal;
        $KegiatanTahapanBaru->akhir =  $date_akhir;
        $KegiatanTahapanBaru->bulan_awal = $bulan_awal;
        $KegiatanTahapanBaru->bulan_akhir = $bulan_akhir;
        $KegiatanTahapanBaru->is_mulai = '0';
        $KegiatanTahapanBaru->yang_isi = $request->yang_isi;
        $KegiatanTahapanBaru->status_spd = '0';
        $KegiatanTahapanBaru->tahun = env('TAHUN', '2020');
        $KegiatanTahapanBaru->capaian_total = 0;
        $KegiatanTahapanBaru->save();

        $capaian_tahapan = new Capaian_Tahapan;
        $capaian_tahapan->id = (string) Uuid::generate();
        $capaian_tahapan->seksi_id = $kegiatan->seksi_id;
        $capaian_tahapan->kegiatan_id = $kegiatan->id;
        $capaian_tahapan->kegiatan_tahapan_id = $KegiatanTahapanBaru->id;
        $capaian_tahapan->target_all = 0;
        $capaian_tahapan->is_mulai = '0';
        $capaian_tahapan->yang_isi = $request->yang_isi;
        $capaian_tahapan->bulan_awal = $bulan_awal;
        $capaian_tahapan->bulan_akhir = $bulan_akhir;
        $capaian_tahapan->tahun = env('TAHUN', '2020');
        $capaian_tahapan->save();
        return $KegiatanTahapanBaru;
    }

    public function tahapanKegiatan_update(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with(["kegiatan.PJ"])
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        // Log::debug($kegiatan_tahapan);
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->tahapanKegiatan_update_helper($request, $kegiatan_tahapan);
                $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->tahapanKegiatan_update_helper($request, $kegiatan_tahapan);
                    $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
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

    public function tahapanKegiatan_update_helper(Request $request, Kegiatan_Tahapan $kegiatan_tahapan)
    {
        $awal_array = explode('-', $request->awal);
        $akhir_array = explode('-', $request->akhir);

        $date_awal = $awal_array[2].'-'.$awal_array[1].'-'.$awal_array[0];
        $bulan_awal = $awal_array[1];

        $date_akhir = $akhir_array[2].'-'.$akhir_array[1].'-'.$akhir_array[0];
        $bulan_akhir = $akhir_array[1];

        $kegiatan_tahapan->nama = $request->nama;
        $kegiatan_tahapan->satuan = $request->satuan;
        if($this->authIsKepala()){
            $kegiatan_tahapan->bobot_kegiatan_tahapan = $request->bobot_kegiatan_tahapan;
        }
        if($kegiatan_tahapan->is_mulai == '0'){
            $kegiatan_tahapan->awal =  $date_awal;
            $kegiatan_tahapan->akhir =  $date_akhir;
            $kegiatan_tahapan->bulan_awal = $bulan_awal;
            $kegiatan_tahapan->bulan_akhir = $bulan_akhir;
            Capaian_Individu::where("id",$kegiatan_tahapan->id)->where("kegiatan_id",$kegiatan_tahapan->kegiatan_id)
                ->update(['bulan_awal' => $bulan_awal, 'bulan_akhir' => $bulan_akhir]);
            Capaian_Tahapan::where("id",$kegiatan_tahapan->id)->where("kegiatan_id",$kegiatan_tahapan->kegiatan_id)
                ->update(['bulan_awal' => $bulan_awal, 'bulan_akhir' => $bulan_akhir]);
            Tahapan_Alokasi_DL::where("id",$kegiatan_tahapan->id)->where("kegiatan_id",$kegiatan_tahapan->kegiatan_id)
                    ->update(['awal' => $date_awal, 'akhir' => $date_akhir]);
        }
        $kegiatan_tahapan->save();
    }

    public function tahapanKegiatan_delete(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with("kegiatan.PJ")
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->tahapanKegiatan_delete_helper($request, $kegiatan_tahapan);
                $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->tahapanKegiatan_delete_helper($request, $kegiatan_tahapan);
                    $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
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

    public function tahapanKegiatan_delete_helper(Request $request, Kegiatan_Tahapan $kegiatan_tahapan)
    {
        Capaian_Individu::where('kegiatan_tahapan_id', $kegiatan_tahapan->id)->delete();
        Capaian_Tahapan::where('kegiatan_tahapan_id', $kegiatan_tahapan->id)->delete();
        DL::where('kegiatan_tahapan_id', $kegiatan_tahapan->id)->delete();
        Tahapan_Alokasi_DL::where('kegiatan_tahapan_id', $kegiatan_tahapan->id)->delete();
        Kegiatan_Tahapan::where('id',  $kegiatan_tahapan->id)->delete();
    }

    public function tahapanKegiatan_alokasi(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with(["kegiatan.PJ", "capaianTahapan"])
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->tahapanKegiatan_alokasi_helper($request, $kegiatan_tahapan);
                $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->tahapanKegiatan_alokasi_helper($request, $kegiatan_tahapan);
                    $this->updateBobotDanDeleteTahapan($request, $idKegiatan);
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

    public function tahapanKegiatan_alokasi_helper(Request $request, Kegiatan_Tahapan $kegiatan_tahapan)
    {
        // $capaian_tahapan = $kegiatan_tahapan->capaianTahapan;
        // Log::debug($request->capaian_tahapan);
        Log::debug($request);

        $awal_array = explode('-', $kegiatan_tahapan->awal);
        $akhir_array = explode('-', $kegiatan_tahapan->akhir);

        $date_awal = $awal_array[2].'-'.$awal_array[1].'-'.$awal_array[0];
        $date_akhir = $akhir_array[2].'-'.$akhir_array[1].'-'.$akhir_array[0];

        Capaian_Tahapan::where("kegiatan_id",$kegiatan_tahapan->kegiatan->id)
            ->where("kegiatan_tahapan_id",$kegiatan_tahapan->id)
            ->update(['target_all' => $request->capaian_tahapan['target_all'],
                'target_01' =>  $request->capaian_tahapan['target_01'],
                'target_02' =>  $request->capaian_tahapan['target_02'],
                'target_03' =>  $request->capaian_tahapan['target_03'],
                'target_04' =>  $request->capaian_tahapan['target_04'],
                'target_05' =>  $request->capaian_tahapan['target_05'],
                'target_06' =>  $request->capaian_tahapan['target_06'],
                'target_07' =>  $request->capaian_tahapan['target_07'],
                'target_08' =>  $request->capaian_tahapan['target_08'],
                'target_09' =>  $request->capaian_tahapan['target_09'],
                'target_10' =>  $request->capaian_tahapan['target_10'],
                'target_11' =>  $request->capaian_tahapan['target_11'],
                'target_12' =>  $request->capaian_tahapan['target_12']]);
       
        $kegiatan_tahapan->target_all = $request->capaian_tahapan['target_all'];
        $kegiatan_tahapan->save();
            
        if(count($request->pair) > 0) {
            foreach($request->pair as $itemAlokasi){
                if($itemAlokasi['status_ubah'] == '1'){
                    if ($itemAlokasi['status_user'] == '0'){
                        //staf
                        $uuid = (string) Uuid::generate();
                        $capaian_individu = new Capaian_Individu;
                        $capaian_individu->id =  $uuid;
                        $capaian_individu->nip_lama = $itemAlokasi['nip_lama'];
                        $capaian_individu->kegiatan_id = $kegiatan_tahapan->kegiatan->id;
                        $capaian_individu->kegiatan_tahapan_id = $kegiatan_tahapan->id;
                        $capaian_individu->target_all =  $itemAlokasi['capaianIndividu']['target_all'];
                        $capaian_individu->tujuan =  $itemAlokasi['capaianIndividu']['tujuan'];
                        $capaian_individu->status_user = $itemAlokasi['status_user'];
                        $capaian_individu->is_mulai =  $kegiatan_tahapan->is_mulai;
                        $capaian_individu->yang_isi =  $kegiatan_tahapan->yang_isi;
                        $capaian_individu->bulan_awal =  $kegiatan_tahapan->bulan_awal;
                        $capaian_individu->bulan_akhir =  $kegiatan_tahapan->bulan_akhir;
                        $capaian_individu->tahun = env('TAHUN', '2020');
                        $capaian_individu->capaian_tahapan_id = $kegiatan_tahapan->capaianTahapan->id;
        
                        $capaian_individu->target_01 = $itemAlokasi['capaianIndividu']['target_01'];
                        $capaian_individu->target_02 = $itemAlokasi['capaianIndividu']['target_02'];
                        $capaian_individu->target_03 = $itemAlokasi['capaianIndividu']['target_03'];
                        $capaian_individu->target_04 = $itemAlokasi['capaianIndividu']['target_04'];
                        $capaian_individu->target_05 = $itemAlokasi['capaianIndividu']['target_05'];
                        $capaian_individu->target_06 = $itemAlokasi['capaianIndividu']['target_06'];
                        $capaian_individu->target_07 = $itemAlokasi['capaianIndividu']['target_07'];
                        $capaian_individu->target_08 = $itemAlokasi['capaianIndividu']['target_08'];
                        $capaian_individu->target_09 = $itemAlokasi['capaianIndividu']['target_09'];
                        $capaian_individu->target_10 = $itemAlokasi['capaianIndividu']['target_10'];
                        $capaian_individu->target_11 = $itemAlokasi['capaianIndividu']['target_11'];
                        $capaian_individu->target_12 = $itemAlokasi['capaianIndividu']['target_12'];
                        $capaian_individu->save();
        
                        $alokasi_dl_item = new Tahapan_Alokasi_DL;
                        $alokasi_dl_item->id = $uuid;
                        $alokasi_dl_item->nip_lama =  $itemAlokasi['nip_lama'];
                        $alokasi_dl_item->seksi_id = $kegiatan_tahapan->kegiatan->seksi_id;
                        $alokasi_dl_item->is_mulai =  $kegiatan_tahapan->is_mulai;
                        $alokasi_dl_item->status_spd = "0";
                        $alokasi_dl_item->kegiatan_id = $kegiatan_tahapan->kegiatan->id;
                        $alokasi_dl_item->kegiatan_tahapan_id = $kegiatan_tahapan->id;
                        $alokasi_dl_item->jumlah_dl = $itemAlokasi['alokasi_dl']['jumlah_dl'];
                        $alokasi_dl_item->real_jumlah_dl = "0";
                        $alokasi_dl_item->awal = $date_awal;
                        $alokasi_dl_item->akhir = $date_akhir;
                        $alokasi_dl_item->tahun = env('TAHUN', '2020');
                        $alokasi_dl_item->save();
        
                    }else if ($itemAlokasi['status_user']  == '1'){
                        //mitra
                        $capaian_individu = new Capaian_Individu;
                        $capaian_individu->id = (string) Uuid::generate();
                        $mita_id = "";
                        if($itemAlokasi['mitra_id']==""){
                            $mitra = new Mitra;
                            $mitra->id = (string) Uuid::generate();
                            $mitra->nama = $itemAlokasi['mitra_nama'];
                            $mitra->save();
                            $mita_id = $mitra->id;
                        }
                        $capaian_individu->mitra_id =  $mita_id;
                        $capaian_individu->kegiatan_id = $kegiatan_tahapan->kegiatan->id;
                        $capaian_individu->kegiatan_tahapan_id = $kegiatan_tahapan->id;
                        $capaian_individu->target_all =  $itemAlokasi['capaianIndividu']['target_all'];
                        $capaian_individu->tujuan =  $itemAlokasi['capaianIndividu']['tujuan'];
                        $capaian_individu->status_user = $itemAlokasi['status_user'];
                        $capaian_individu->is_mulai =  $kegiatan_tahapan->is_mulai;
                        $capaian_individu->yang_isi =  $kegiatan_tahapan->yang_isi;
                        $capaian_individu->bulan_awal =  $kegiatan_tahapan->bulan_awal;
                        $capaian_individu->bulan_akhir =  $kegiatan_tahapan->bulan_akhir;
                        $capaian_individu->tahun = env('TAHUN', '2020');
                        $capaian_individu->capaian_tahapan_id = $kegiatan_tahapan->capaianTahapan->id;
        
                        $capaian_individu->target_01 = $itemAlokasi['capaianIndividu']['target_01'];
                        $capaian_individu->target_02 = $itemAlokasi['capaianIndividu']['target_02'];
                        $capaian_individu->target_03 = $itemAlokasi['capaianIndividu']['target_03'];
                        $capaian_individu->target_04 = $itemAlokasi['capaianIndividu']['target_04'];
                        $capaian_individu->target_05 = $itemAlokasi['capaianIndividu']['target_05'];
                        $capaian_individu->target_06 = $itemAlokasi['capaianIndividu']['target_06'];
                        $capaian_individu->target_07 = $itemAlokasi['capaianIndividu']['target_07'];
                        $capaian_individu->target_08 = $itemAlokasi['capaianIndividu']['target_08'];
                        $capaian_individu->target_09 = $itemAlokasi['capaianIndividu']['target_09'];
                        $capaian_individu->target_10 = $itemAlokasi['capaianIndividu']['target_10'];
                        $capaian_individu->target_11 = $itemAlokasi['capaianIndividu']['target_11'];
                        $capaian_individu->target_12 = $itemAlokasi['capaianIndividu']['target_12'];
                        $capaian_individu->save();
                    }
                }else if($itemAlokasi['status_ubah'] == '0'){
                    Capaian_Individu::where("id", $itemAlokasi['capaianIndividu']['id'])
                        ->where("kegiatan_id",$kegiatan_tahapan->kegiatan->id)
                        ->where("kegiatan_tahapan_id",$kegiatan_tahapan->id)
                        ->update(['target_all' =>  $itemAlokasi['capaianIndividu']['target_all'],
                            'tujuan' =>  $itemAlokasi['capaianIndividu']['tujuan'],
                            'target_01' =>  $itemAlokasi['capaianIndividu']['target_01'],
                            'target_02' =>  $itemAlokasi['capaianIndividu']['target_02'],
                            'target_03' =>  $itemAlokasi['capaianIndividu']['target_03'],
                            'target_04' =>  $itemAlokasi['capaianIndividu']['target_04'],
                            'target_05' =>  $itemAlokasi['capaianIndividu']['target_05'],
                            'target_06' =>  $itemAlokasi['capaianIndividu']['target_06'],
                            'target_07' =>  $itemAlokasi['capaianIndividu']['target_07'],
                            'target_08' =>  $itemAlokasi['capaianIndividu']['target_08'],
                            'target_09' =>  $itemAlokasi['capaianIndividu']['target_09'],
                            'target_10' =>  $itemAlokasi['capaianIndividu']['target_10'],
                            'target_11' =>  $itemAlokasi['capaianIndividu']['target_11'],
                            'target_12' =>  $itemAlokasi['capaianIndividu']['target_12']]);
                    
                            // Log::debug($itemAlokasi);
                    if($itemAlokasi['status_user'] == '0'){
                        Tahapan_Alokasi_DL::where("id", $itemAlokasi['capaianIndividu']['id'])
                            ->where("kegiatan_id", $kegiatan_tahapan->kegiatan->id)
                            ->where("kegiatan_tahapan_id",$kegiatan_tahapan->id)
                            ->update(['jumlah_dl' => $itemAlokasi['alokasi_dl']['jumlah_dl']]);
                    }
                   
                }if($itemAlokasi['status_ubah'] == '2'){
                    Capaian_Individu::where("id",$itemAlokasi['capaianIndividu']['id'])
                        ->where("kegiatan_id", $kegiatan_tahapan->kegiatan->id)
                        ->where("kegiatan_tahapan_id",$kegiatan_tahapan->id)
                        ->delete();
                    Tahapan_Alokasi_DL::where("id",$itemAlokasi['capaianIndividu']['id'])
                        ->where("kegiatan_id", $kegiatan_tahapan->kegiatan->id)
                        ->where("kegiatan_tahapan_id",$kegiatan_tahapan->id)
                        ->delete();
                }
            }
        }
    }

    public function tahapanKegiatan_start(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with(["kegiatan.PJ"])
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->tahapanKegiatan_start_helper($request, $idKegiatan, $idKegiatanTahapan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->tahapanKegiatan_start_helper($request, $idKegiatan, $idKegiatanTahapan);
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

    public function tahapanKegiatan_start_helper(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        Capaian_Individu::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '1']);
        Capaian_Tahapan::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '1']);
        Tahapan_Alokasi_DL::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '1']);
        Kegiatan_Tahapan::where('kegiatan_id', $idKegiatan)
            ->where('id', $idKegiatanTahapan)
            ->update(['is_mulai' => '1']);
    }

    public function tahapanKegiatan_stop(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        $kegiatan_tahapan = Kegiatan_Tahapan::with(["kegiatan.PJ"])
            ->where("id",$idKegiatanTahapan)
            ->where("kegiatan_id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan_tahapan->kegiatan->seksi_id)){
            DB::beginTransaction();
            try{
                $this->tahapanKegiatan_stop_helper($request, $idKegiatan, $idKegiatanTahapan);
                DB::commit();
                return 1;
            }catch(Exception $e){
                DB::rollBack();
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan_tahapan->kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                DB::beginTransaction();
                try{
                    $this->tahapanKegiatan_stop_helper($request, $idKegiatan, $idKegiatanTahapan);
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

    public function tahapanKegiatan_stop_helper(Request $request, $idKegiatan, $idKegiatanTahapan)
    {
        DL::where('kegiatan_tahapan_id', $idKegiatanTahapan)->delete();
        Capaian_Individu::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '0']);
        Capaian_Tahapan::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '0']);
        Tahapan_Alokasi_DL::where('kegiatan_id', $idKegiatan)
            ->where('kegiatan_tahapan_id', $idKegiatanTahapan)
            ->update(['is_mulai' => '0']);
        Kegiatan_Tahapan::where('kegiatan_id', $idKegiatan)
            ->where('id', $idKegiatanTahapan)
            ->update(['is_mulai' => '0']);
    }

    public function addNewPJ(Request $request , $idKegiatan)
    {
        $kegiatan = Kegiatan::with("PJ")
            ->where("id", $idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            try{
                $kegiatan_pj_new = $this->addNewPJ_helper($request, $kegiatan);
                return $kegiatan_pj_new->id;
            }catch(Exception $e){
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                try{
                    $kegiatan_pj_new = $this->addNewPJ_helper($request, $kegiatan);
                    return $kegiatan_pj_new->id;
                }catch(Exception $e){
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }
    public function addNewPJ_helper(Request $request, Kegiatan $kegiatan )
    {
        $kegiatan_pj_new = new Kegiatan_PJ;
        $kegiatan_pj_new->id = (string) Uuid::generate();
        $kegiatan_pj_new->kegiatan_id = $request->kegiatan_id;
        $kegiatan_pj_new->nip_lama = $request->nip_lama;
        $kegiatan_pj_new->save();
        return $kegiatan_pj_new;
    }

    public function deleteNewPJ(Request $request , $idKegiatan)
    {
       $kegiatan = Kegiatan::with("PJ")
            ->where("id", $idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            try{
                $this->deleteNewPJ_helper($request, $kegiatan);
                return '1';
            }catch(Exception $e){
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                try{
                    $this->deleteNewPJ_helper($request, $kegiatan);
                    return '1';
                }catch(Exception $e){
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }

    public function deleteNewPJ_helper(Request $request, Kegiatan $kegiatan)
    {
        Kegiatan_PJ::where('id', $request->id)->delete();
    }

    public function downloadTemplate(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::with(["PJ.user","kegiatanTahapan.capaianTahapan.capaianIndividu"])
            ->where("id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            return $kegiatan->toJson();
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                break;
                }
            }
            if($isPj){
                return $kegiatan;
            }else{
                return abort(403);
            }
        }
    }

    public function  downloadTemplate_helper(Request $request, Kegiatan $kegiatan){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B1','testing');
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'tessa';
        
        $writer->save($filename);
    }

    public function uploadTemplate(Request $request, $idKegiatan)
    {
        $kegiatan = Kegiatan::with(["PJ", 'kegiatanTahapan.capaianTahapan.capaianIndividu'])
            ->where("id",$idKegiatan)
            ->first();
        if($this->authCanTahapan($kegiatan->seksi_id)){
            try{
                $this->uploadTemplate_helper($request, $kegiatan);
                return '1';
            }catch(Exception $e){
                return abort(500);
            }
        }else{
            $isPj = FALSE;
            foreach($kegiatan->PJ as $kegiatanPj){
                if($kegiatanPj->nip_lama == auth()->user()->nip_lama){
                    $isPj = TRUE;
                    break;
                }
            }
            if($isPj){
                try{
                    $this->uploadTemplate_helper($request, $kegiatan);
                    return '1';
                }catch(Exception $e){
                    return abort(500);
                }
            }else{
                return abort(403);
            }
        }
    }
    public function uploadTemplate_helper(Request $request, Kegiatan $kegiatan)
    {
        $uuidFile = (string) Uuid::generate();
        //upload
        $file = $request->file('file');
        $file->move(public_path().'/xls', $uuidFile.'.'.$file->getClientOriginalExtension());

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load(public_path().'/xls/'. $uuidFile.'.'.$file->getClientOriginalExtension());
        
        $worksheet = $spreadsheet->getActiveSheet();
        // Get the highest row and column numbers referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = 31; // e.g 'F'
        $file_rows = [];
        
        for ($row = 3; $row <= $highestRow; ++$row) {
            $itemData = [
                $worksheet->getCellByColumnAndRow(1, $row)->getValue(), $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(3, $row)->getValue(), $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(5, $row)->getValue(), $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(7, $row)->getValue(), $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(9, $row)->getValue(), $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(11, $row)->getValue(), $worksheet->getCellByColumnAndRow(12, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(13, $row)->getValue(), $worksheet->getCellByColumnAndRow(14, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(15, $row)->getValue(), $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(17, $row)->getValue(), $worksheet->getCellByColumnAndRow(18, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(19, $row)->getValue(), $worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(21, $row)->getValue(), $worksheet->getCellByColumnAndRow(22, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(23, $row)->getValue(), $worksheet->getCellByColumnAndRow(24, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(25, $row)->getValue(), $worksheet->getCellByColumnAndRow(26, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(27, $row)->getValue(), $worksheet->getCellByColumnAndRow(28, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(29, $row)->getValue(), $worksheet->getCellByColumnAndRow(30, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(31, $row)->getValue(), $worksheet->getCellByColumnAndRow(32, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(33, $row)->getValue(), $worksheet->getCellByColumnAndRow(34, $row)->getValue(),
                $worksheet->getCellByColumnAndRow(35, $row)->getValue()
            ];
            array_push($file_rows, $itemData);
        }
        $file_rows = array_reverse($file_rows);
    }

    public function get10UUID(){
        
    }
}