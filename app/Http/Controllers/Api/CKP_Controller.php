<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class CKP_Controller extends Controller
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

     // target 
     public function target_get(Request $request)
     {
         return ;
     }
 
     public function target_create(Request $request)
     {
         return ;
     }
 
     public function target_add(Request $request)
     {
         return ;
     }
 
     public function target_update(Request $request)
     {
         return ;
     }
 
     public function target_submit(Request $request)
     {
         return ;
     }
     // realisasi
     public function real_get(Request $request)
     {
         return ;
     }
 
     public function real_create(Request $request)
     {
         return ;
     }
 
     public function real_add(Request $request)
     {
         return ;
     }
 
     public function real_update(Request $request)
     {
         return ;
     }
 
     public function real_submit(Request $request)
     {
         return ;
     }

}