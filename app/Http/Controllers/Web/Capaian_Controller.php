<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Trait_Capaian;

class Capaian_Controller extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    use Trait_Capaian;

    public function __construct()
    {
        $this->middleware('auth');
        if (!Auth::check()) {
            return redirect()->action('Web\Auth@showLoginForm');
        }
    }

  
    
}