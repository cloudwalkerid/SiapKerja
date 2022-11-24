<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

use App\Model\Tahapan_Alokasi_DL;
use App\Model\DL;

trait Trait_DL {
    public function showDL(Request $request, $month, $year)
    {
        $hasil = [];
        $alokasi = Tahapan_Alokasi_DL::with(["kegiatan", "kegiatanTahapan"])
            ->where('nip_lama', auth()->user()->nip_lama)
            ->where('tahun', $itemDL['tahun'])
            ->get();
        $dl = DL::where('nip_lama', auth()->user()->nip_lama)
            ->where('bulan', sprintf('%02d',$itemDL['bulan']))
            ->where('tahun', $itemDL['tahun'])
            ->get();

        $hasil['alokasi'] = $alokasi;
        $hasil['dl'] = $dl;
        return $hasil;
    }
    public function showDLLainnya(Request $request, $month, $year, $nip_lama)
    {
        $dl = DL::where('nip_lama', $nip_lama)
            ->where('bulan', sprintf('%02d',$itemDL['bulan']))
            ->where('tahun', $itemDL['tahun'])
            ->get();
        return $dl;
    }
    public function updateDL(Request $request, $idAlokasiKegiatanTahapan)
    {
        DB::beginTransaction();
        try{
            $dataDL = json_decode($request->data);
            $kegiatan_tahapan_alokasi_dl_id_all = [];
            foreach($dataDL as $itemDL){
                if($itemDL['action'] == 0){
                    //create
                    $dl_item = new DL;
                    $dl_item->nip_lama = (string) Uuid::generate();
                    $dl_item->nip_lama = auth()->user()->nip_lama;
                    $dl_item->seksi_id = $itemDL['seksi_id'];
                    $dl_item->status_spd = '0';
                    $dl_item->kegiatan_id = $itemDL['kegiatan_id'];
                    $dl_item->kegiatan_tahapan_id = $itemDL['kegiatan_tahapan_id'];
                    $dl_item->kegiatan_tahapan_alokasi_dl_id = $itemDL['kegiatan_tahapan_alokasi_dl_id'];
                    $dl_item->tanggal = sprintf('%02d',$itemDL['tanggal']);
                    $dl_item->bulan = sprintf('%02d',$itemDL['bulan']);
                    $dl_item->tahun = $itemDL['tahun'];
                    $dl_item->save();

                }else if($itemCKP->action == 1){
                    //update
                    DL::where('id', $itemDL['id'])
                        ->where('nip_lama', auth()->user()->nip_lama)
                        ->where('tanggal', sprintf('%02d',$itemDL['tanggal']))
                        ->where('bulan', sprintf('%02d',$itemDL['bulan']))
                        ->where('tahun', $itemDL['tahun'])
                        ->update(['kegiatan_id' => $itemDL['kegiatan_id']
                            ,'kegiatan_tahapan_id' => $itemDL['kegiatan_tahapan_id']
                            ,'kegiatan_tahapan_alokasi_dl_id' => $itemDL['kegiatan_tahapan_alokasi_dl_id']]);
                }else if($itemCKP->action == 2){
                    //delete
                    DL::where('id', $itemDL['id'])
                        ->where('nip_lama', auth()->user()->nip_lama)
                        ->where('tanggal', sprintf('%02d',$itemDL['tanggal']))
                        ->where('bulan', sprintf('%02d',$itemDL['bulan']))
                        ->where('tahun', $itemDL['tahun'])
                        ->delete();
                }
                array_push($kegiatan_tahapan_alokasi_dl_id_all, $itemDL['kegiatan_tahapan_alokasi_dl_id']);
            }
            $array_unique = array_unique($kegiatan_tahapan_alokasi_dl_id_all);
            foreach($array_unique as $itemUnique){
                $countDL = DL::where('kegiatan_tahapan_alokasi_dl_id', $itemUnique)
                    ->where('nip_lama', auth()->user()->nip_lama)    
                    ->count();
                Tahapan_Alokasi_DL::where('id', $itemUnique)
                    ->where('nip_lama', auth()->user()->nip_lama)
                    ->update(['real_jumlah_dl' => $countDL]);
            }
            DB::commit();
            return 1;
        }catch(Exception $e){
            DB::rollBack();
            return abort(500);
        }
    }    
}