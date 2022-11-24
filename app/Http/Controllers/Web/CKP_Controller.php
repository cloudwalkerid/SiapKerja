<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Http\Traits\Trait_CKP;
use Illuminate\Support\Facades\Auth;

class CKP_Controller extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    use Trait_CKP;

    public function __construct()
    {
        $this->middleware('auth');
        if (!Auth::check()) {
            return redirect()->action('Web\Auth@showLoginForm');
        }
    }


}