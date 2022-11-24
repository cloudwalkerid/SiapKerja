<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class DL_Controller extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show(Request $request)
    {
        return ;
    }

    public function update(Request $request)
    {
        return ;
    }

}