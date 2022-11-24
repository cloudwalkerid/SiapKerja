<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

use App\Model\Capaian_Individu;
use App\Model\CKP;
use App\Model\CKP_Item;
use App\Http\Traits\Trait_Capaian;

use Illuminate\Support\Facades\Log;
use PDF;
use Response;

trait Trait_CKP {

    use Trait_Capaian;

    public function showCKP(Request $request, $month, $year)
    {
        $month = sprintf('%02d', $month);
        $ckp = CKP::with(["ckpItem.capaianIndividu"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("bulan", $month)
            ->where("tahun", $year)
            ->first();
        // Log::debug($ckp);

        $alreadyIn = [];
        if($ckp != null){
            foreach($ckp->ckpItem as $itemCKP){
                if($itemCKP->capaian_individu_id != null){
                    array_push($alreadyIn, $itemCKP->capaian_individu_id);
                }
            }
        }
        $capaian_individu = Capaian_Individu::with(["kegiatan", "kegiatanTahapan"])
            ->whereNotIn('id', $alreadyIn)
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("is_mulai", '1')
            ->where("target_".sprintf('%02d', $month), ">", 0)
            ->where("tahun", $year)
            ->get();
            // Log::debug($capaian_individu);
        $data = [];
        $data['ckp'] = $ckp;
        $data['capaian_individu'] = $capaian_individu;
        return $data;
    }

    public function target_get(Request $request, $month, $year)
    {
        $hasil = [];
        $capaian_individu = Capaian_Individu::with(["kegiatan", "kegiatanTahapan"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("is_mulai", '1')
            ->where("target_".sprintf('%02d', $month), ">", 0)
            ->where("tahun", $year)
            ->get();
        $ckp_bulan_lalu = CKP::with(["ckpItemNotFull.capaianIndividu"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("bulan", sprintf('%02d', ($month-1)))
            ->where("tahun", $year)
            ->first();
        $hasil['ckp_bulan_lalu'] =  $ckp_bulan_lalu;
        $hasil['individu'] =  $capaian_individu;
        return $hasil;
    }
    
    public function target_submit(Request $request, $month, $year)
    {
        DB::beginTransaction();
        try{
            $capaian_individu = Capaian_Individu::where("nip_lama", auth()->user()->nip_lama)
                ->where("is_mulai", '1')
                ->where("target_".sprintf('%02d', $month), ">", 0)
                ->where("tahun", $year)
                ->get();

            $uuid = (string) Uuid::generate();

            $ckp = new CKP;
            $ckp->id = $uuid;
            $ckp->nip_lama = auth()->user()->nip_lama;
            $ckp->bulan = sprintf('%02d', $month);
            $ckp->tahun = $year;
            $ckp->status = '0';
            $ckp->ttd_t_nip_lama = $request->nip_lama;
            $ckp->ckp_t_ttd = date("Y-m-d");
            $ckp->save();
            // Log::debug($request);
            foreach($request->data as $item){
                $ckp_item = new CKP_Item;
                $ckp_item->id = (string) Uuid::generate();
                $ckp_item->ckp_id = $uuid;
                $ckp_item->nama = $item['nama'];
                $ckp_item->satuan = $item['satuan'];
                $ckp_item->target = $item['target'];
                $ckp_item->realisasi = 0;
                if(array_key_exists("capaian_individu_id",$item)){
                    $ckp_item->capaian_individu_id =  $item['capaian_individu_id'];
                    foreach($capaian_individu as $item){
                        if($item->id == $ckp_item->capaian_individu_id){
                            if($month == 1){
                                $ckp_item->realisasi = $item->realisasi_01;
                            }else if($month == 2){
                                $ckp_item->realisasi = $item->realisasi_02;
                            }else if($month == 3){
                                $ckp_item->realisasi = $item->realisasi_03;
                            }else if($month == 4){
                                $ckp_item->realisasi = $item->realisasi_04;
                            }else if($month == 5){
                                $ckp_item->realisasi = $item->realisasi_05;
                            }else if($month == 6){
                                $ckp_item->realisasi = $item->realisasi_06;
                            }else if($month == 7){
                                $ckp_item->realisasi = $item->realisasi_07;
                            }else if($month == 8){
                                $ckp_item->realisasi = $item->realisasi_08;
                            }else if($month == 9){
                                $ckp_item->realisasi = $item->realisasi_09;
                            }else if($month == 10){
                                $ckp_item->realisasi = $item->realisasi_10;
                            }else if($month == 11){
                                $ckp_item->realisasi = $item->realisasi_11;
                            }else if($month == 12){
                                $ckp_item->realisasi = $item->realisasi_12;
                            }
                        }
                    }
                }
                $ckp_item->is_delete = 0;
                $ckp_item->save();
            }
            DB::commit();
            return $uuid;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }

    public function real_add(Request $request, $month, $year)
    {
        DB::beginTransaction();
        try{
            $ckp = CKP::where('nip_lama', auth()->user()->nip_lama)
                ->where('bulan', sprintf('%02d', $month))
                ->where('tahun', $year)
                ->first();
            
            $uuid = (string) Uuid::generate();
            $ckp_item = new CKP_Item;
            $ckp_item->id = $uuid;
            $ckp_item->ckp_id = $ckp->id;
            $ckp_item->capaian_individu_id =  $request->capaian_individu_id;
            $ckp_item->satuan = $request->satuan;
            $ckp_item->nama = $request->nama;
            $ckp_item->target = $request->target;
            $ckp_item->realisasi = $request->realisasi;
            $ckp_item->is_delete = 0;
            $ckp_item->save();

            DB::commit();
            return $uuid;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }

    public function real_delete(Request $request, $month, $year, $idCKPItem)
    {
        DB::beginTransaction();
        try{
            $ckp_item = CKP_Item::with(["ckp"])
                    ->where('id', $idCKPItem)
                    ->first();
                
            $capaian_individu = $ckp_item->capaianIndividu;
            if($ckp_item->ckp->status == '0'){
                return abort(403);
            }
            if($ckp_item->ckp->nip_lama != auth()->user()->nip_lama){
                return abort(403);
            }
            $ckp_item->is_delete = '1';
            $ckp_item->save();
            DB::commit();
            return $uuid;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }

    public function real_update(Request $request, $month, $year, $idCKPItem)
    {
        DB::beginTransaction();
        try{ 
            $month = sprintf('%02d', $month);
            $ckp_item = CKP_Item::with(["ckp", "capaianIndividu.capaianTahapan"])
                ->where('id', $idCKPItem)
                ->first();
            if($ckp_item->capaian_individu_id != null){
                //capaian individu
               
                $capaian_individu = $ckp_item->capaianIndividu;
                if($ckp_item->ckp->status == '1'){
                    return abort(403);
                }
                if($ckp_item->ckp->nip_lama != auth()->user()->nip_lama ||  $capaian_individu->nip_lama != auth()->user()->nip_lama){
                    return abort(403);
                }
                $ckp_item->realisasi =  $request->realisasi;
                $ckp_item->save();
                $capaian_tahapan = $capaian_individu->capaianTahapan;
                if ($month == '01'){
                    $capaian_tahapan->realisasi_01 = $capaian_tahapan->realisasi_01 - $capaian_individu->realisasi_01 + $request->realisasi;
                    $capaian_individu->realisasi_01 = $request->realisasi;
                }else if ($month == '02'){
                    $capaian_tahapan->realisasi_02 = $capaian_tahapan->realisasi_02 - $capaian_individu->realisasi_02 + $request->realisasi;
                    $capaian_individu->realisasi_02 = $request->realisasi;
                }else if ($month == '03'){
                    $capaian_tahapan->realisasi_03 = $capaian_tahapan->realisasi_03 - $capaian_individu->realisasi_03 + $request->realisasi;
                    $capaian_individu->realisasi_03 = $request->realisasi;
                }else if ($month == '04'){
                    $capaian_tahapan->realisasi_04 = $capaian_tahapan->realisasi_04 - $capaian_individu->realisasi_04 + $request->realisasi;
                    $capaian_individu->realisasi_04 = $request->realisasi;
                }else if ($month == '05'){
                    $capaian_tahapan->realisasi_05 = $capaian_tahapan->realisasi_05 - $capaian_individu->realisasi_05 + $request->realisasi;
                    $capaian_individu->realisasi_05 = $request->realisasi;
                }else if ($month == '06'){
                    $capaian_tahapan->realisasi_06 = $capaian_tahapan->realisasi_06 - $capaian_individu->realisasi_06 + $request->realisasi;
                    $capaian_individu->realisasi_06 = $request->realisasi;
                }else if ($month == '07'){
                    $capaian_tahapan->realisasi_07 = $capaian_tahapan->realisasi_07 - $capaian_individu->realisasi_07 + $request->realisasi;
                    $capaian_individu->realisasi_07 = $request->realisasi;
                }else if ($month == '08'){
                    $capaian_tahapan->realisasi_08 = $capaian_tahapan->realisasi_08 - $capaian_individu->realisasi_08 + $request->realisasi;
                    $capaian_individu->realisasi_08 = $request->realisasi;
                }else if ($month == '09'){
                    $capaian_tahapan->realisasi_09 = $capaian_tahapan->realisasi_09 - $capaian_individu->realisasi_09 + $request->realisasi;
                    $capaian_individu->realisasi_09 = $request->realisasi;
                }else if ($month == '10'){
                    $capaian_tahapan->realisasi_10 = $capaian_tahapan->realisasi_10 - $capaian_individu->realisasi_10 + $request->realisasi;
                    $capaian_individu->realisasi_10 = $request->realisasi;
                }else if ($month == '11'){
                    $capaian_tahapan->realisasi_11 = $capaian_tahapan->realisasi_11 - $capaian_individu->realisasi_11 + $request->realisasi;
                    $capaian_individu->realisasi_11 = $request->realisasi;
                }else if ($month == '12'){
                    $capaian_tahapan->realisasi_12 = $capaian_tahapan->realisasi_12 - $capaian_individu->realisasi_12 + $request->realisasi;
                    $capaian_individu->realisasi_12 = $request->realisasi;
                }
                
                $capaian_tahapan->save();
                $capaian_individu->save();
                $this->updateAlokasidanCapaian($request, $capaian_individu->capaianTahapan);
            }else if($ckp_item->capaian_individu_id == null){
                //ckp item
                if($ckp_item->ckp->status == '1'){
                    return abort(403);
                }
                if($ckp_item->ckp->nip_lama != auth()->user()->nip_lama){
                    return abort(403);
                }
                $ckp_item->realisasi = $request->realisasi;
                $ckp_item->save();
            }
            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }

    public function real_submit(Request $request, $month, $year)
    {
        DB::beginTransaction();
        $month = sprintf('%02d', $month);
        try{
            $ckp = CKP::where('nip_lama', auth()->user()->nip_lama)
                ->where('bulan', sprintf('%02d', $month))
                ->where('tahun', $year)
                ->first();
            $ckp->status = '1';
            $ckp->ttd_r_nip_lama = $request->nip_lama;
            $ckp->ckp_r_ttd = date("Y-m-d");
            $ckp->save();

            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }
    public function print_t(Request $request, $month, $year)
    {
        $month = sprintf('%02d', $month);
        $ckp = CKP::with(["ckpItem", "ttd_t"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("bulan", $month)
            ->where("tahun", $year)
            ->first();
        // Log::debug($ckp);
        if(file_exists(storage_path().'/pdf/target/'.$ckp->id.'.pdf')){
            $file= storage_path().'/pdf/target/'.$ckp->id.'.pdf';
            $headers = ['Content-Type' => 'application/pdf',];
            return Response::download($file, 'CKP-T '.auth()->user()->nama.' '.$month.'-'.$year.'.pdf', $headers);
        }else{
            $pdf = PDF::loadView('use.ckp_t',['user'=>auth()->user(), 'ckp'=>$ckp])->setPaper('a4', 'landscape')
                ->setWarnings(false)->save(storage_path().'/pdf/target/'.$ckp->id.'.pdf');
            $file= storage_path().'/pdf/target/'.$ckp->id.'.pdf';
            $headers = ['Content-Type' => 'application/pdf',];
            return Response::download($file, 'CKP-T '.auth()->user()->nama.' '.$month.'-'.$year.'.pdf', $headers);
        }
       
        // return view('use.ckp_t',['ckp'=>$ckp]);
    }
    public function print_r(Request $request, $month, $year)
    {
        $month = sprintf('%02d', $month);
        $ckp = CKP::with(["ckpItem", "ttd_r"])
            ->where("nip_lama", auth()->user()->nip_lama)
            ->where("bulan", $month)
            ->where("tahun", $year)
            ->first();
        $jumlah = 0;
        $count = 0;
        foreach($ckp->ckpItem as $item){
            $jumlah = $jumlah + $item->capaian;
            $count = $count +1;
        }
        $capaian = number_format(($jumlah/$count), 2, ',', ' ');
        $data = [
            'ckp'=>$ckp, 
            'capaian'=>strval($capaian)
            ];
        // Log::debug($ckp);
        // return view('use.ckp_r',$data);
        if(file_exists(storage_path().'/pdf/realisasi/'.$ckp->id.'.pdf')){
            $file= storage_path().'/pdf/realisasi/'.$ckp->id.'.pdf';
            $headers = ['Content-Type' => 'application/pdf',];
            return Response::download($file, 'CKP-R '.auth()->user()->nama.' '.$month.'-'.$year.'.pdf', $headers);
        }else{
            $pdf = PDF::loadView('use.ckp_r', $data)->setPaper('a4', 'landscape')
                ->setWarnings(false)->save(storage_path().'/pdf/realisasi/'.$ckp->id.'.pdf');
            $file= storage_path().'/pdf/realisasi/'.$ckp->id.'.pdf';
            $headers = ['Content-Type' => 'application/pdf',];
            return Response::download($file, 'CKP-R '.auth()->user()->nama.' '.$month.'-'.$year.'.pdf', $headers);
        }
    }
}