<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth:admin');
     }
     
     public function index()
    {
        $totalUsers = User::count();
        $group_type_obj = '';

        $data = array(
            'total_users'=>$totalUsers,
        );
        return view('layouts.admins.dashboard',$data);
    }

    
}
