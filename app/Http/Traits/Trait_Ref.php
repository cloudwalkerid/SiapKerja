<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use App\Model\Ref_Kegiatan;

trait Trait_Ref {

    public function showRef(Request $request)
    {
        if( auth()->user()->seksi_id == "030" && auth()->user()->is_kasi_plt == "1"){
            return abort(403);
        }
        $ref_all = Ref_Kegiatan::all();
        return $ref_all->toJson();
    }

    public function createRef(Request $request)
    {
        if( auth()->user()->seksi_id == "030" && auth()->user()->is_kasi_plt == "1"){
            return abort(403);
        }
        try{
            $refKegiatan = new Ref_Kegiatan();
            $refKegiatan->ref_kode = $request->ref_kode;
            $refKegiatan->nama = $request->nama;
            $refKegiatan->bobot = $request->bobot;
            $refKegiatan->save();
            return '1';
        }catch(Exception $e){
            return abort(500);
        }
    }

    public function updateRef(Request $request)
    {
        if( auth()->user()->seksi_id == "030" && auth()->user()->is_kasi_plt == "1"){
            return abort(403);
        }
        try{
            $refKegiatan = Ref_Kegiatan()::where("ref_kode",$request->ref_kode)->get();
            $refKegiatan->nama = $request->nama;
            $refKegiatan->bobot = $request->bobot;
            $refKegiatan->save();
            return '1';
        }catch(Exception $e){
            return abort(500);
        }
    }

    public function deleteRef(Request $request)
    {
        if( auth()->user()->seksi_id == "030" && auth()->user()->is_kasi_plt == "1"){
            return abort(403);
        }
        try{
            $refKegiatan = Ref_Kegiatan()::where("ref_kode",$request->ref_kode)->get();
            $refKegiatan->delete();
            return '1';
        }catch(Exception $e){
            return abort(500);
        }
    }

    
}