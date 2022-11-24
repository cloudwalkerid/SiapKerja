<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\Model\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use App\Model\Seksi;
use App\Model\Ref_Kegiatan;

class Web_Controller extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */


    public function __construct()
    {
        $this->middleware('auth');
        if (!Auth::check()) {
            return redirect()->action('Web\Auth@showLoginForm');
        }
    }

    public function webshow(Request $request)
    {
        $user  = auth()->user();
        $allseksi = Seksi::all();
        return view('use.index', ['user' => $user, 'allseksi' => $allseksi]);
    }


    public function getListUser(Request $request)
    {
        $alluser = User::all();
        return $alluser->toJson();
    }

    public function getListMitra(Request $request)
    {
        $allmitra = Mitra::all();
        return $allmitra->toJson();
    }

    public function getListReferensi(Request $request)
    {
        $allmitra = Ref_Kegiatan::all();
        return $allmitra->toJson();
    }

    
}