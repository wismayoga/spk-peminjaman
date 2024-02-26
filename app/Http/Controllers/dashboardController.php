<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        //render view with posts
        return view('dashboard.index');
        
    }
}
